<?php

namespace geoquizz\service\domain\services;

use geoquizz\service\domain\DTO\PartieDTO;
use geoquizz\service\domain\entities\Partie;
use geoquizz\service\domain\entities\Partie_cache;
use geoquizz\service\domain\entities\Partie_schema;
use GuzzleHttp\Client;
use Ramsey\Uuid\Uuid;

class SsPartie
{

    private SsSerie $SsSerie;

    public function __construct(SsSerie $s)
    {
        $this->SsSerie = $s;
    }

    public function getGames()
    {
        $games = Partie::all();
        $tab = [];
        foreach ($games as $p) {
            $serie_nom = $this->SsSerie->getSerieById($p->serie_id);
            $tab[] = new PartieDTO($p->id, $p->user_email, $p->score, $p->difficulte, $p->serie_id, $serie_nom->nom, $p->user_username);
        }
        return $tab;
    }

    public function getGameId($id)
    {
        $p = Partie::where("id", $id)->first();
        $serie_nom = $this->SsSerie->getSerieById($p->serie_id);
        return new PartieDTO($p->id, $p->user_email, $p->score, $p->difficulte, $p->serie_id, $serie_nom->nom, $p->user_username);
    }


    public function getHistory($user_email)
    {
        $parties = Partie::where("user_email", $user_email)->get();
        $tab = [];
        foreach ($parties as $p) {
            $serie_nom = $this->SsSerie->getSerieById($p->serie_id);
            $tab[] = new PartieDTO($p->id, $p->user_email, $p->score, $p->difficulte, $p->serie_id, $serie_nom->nom, $p->user_username);
        }
        return $tab;
    }

    public function createParty($serie_id, $user_email, $user_username, $difficulte)
    {
        if ($difficulte > 3 || $difficulte < 1){
            throw new \Exception("Mauvaise difficulté");
        }
        $game_id = Uuid::uuid4();
        $partieCache = new Partie_cache();
        $partieCache->id = $game_id;
        $partieCache->user_email = $user_email;
        $partieCache->user_username = $user_username;
        $partieCache->serie_id = $serie_id;
        $partieCache->tours = 0;
        $partieCache->distance = 0;
        $partieCache->temps = 0;
        $partieCache->difficulte = $difficulte;
        $partieCache->save();

        $allLocalisation = $this->SsSerie->getLocalisationBySerie($serie_id);

        shuffle($allLocalisation);

        $prise = 0;
        if ($difficulte == 1) $prise = 8;
        if ($difficulte == 2) $prise = 10;
        if ($difficulte == 3) $prise = 12;

        $localisation = array_slice($allLocalisation, 0, $prise);

        $serie = $this->SsSerie->getSerieById($serie_id);

        $tours = 0;
        foreach ($localisation as $l){
            $tours += 1;
            $schemaRecord = new Partie_schema();
            $schemaRecord->partie_id = $game_id;
            $schemaRecord->tours = $tours;
            $schemaRecord->localisation_id = $l->id;
            $schemaRecord->save();
        }



        return [
            "user_username" => $user_username,
            "user_email" => $user_email,
            "serie_id" => $serie_id,
            "serie_nom" => $serie->nom,
            "game_id" => $game_id,
            "startmap" => $serie->startmap,
            "localisations" => $localisation,
        ];
    }

    //RETOUR
    //1 : continue
    //2 : fin
    public function playParty($game_id, $distance, $temps)
    {
        $record = Partie_cache::where("id", $game_id)->get();
        $nbRecord = $record->count();
        $lastRecord = Partie_cache::where("id", $game_id)->latest("tours")->first();
        $difficulte = $lastRecord->difficulte;
        if ($difficulte == 1) $fin = 8;
        if ($difficulte == 2) $fin = 10;
        if ($difficulte == 3) $fin = 12;

        if ($nbRecord == 0) {
            throw new \Exception("Partie non existante");
        }

        if ($nbRecord > $fin) {
            throw new \Exception("Normalement la partie aurait du finir si ce message s'affiche c'est la faute de moi");
        }

        if ($nbRecord == $fin) {
            //Todo Ajout
            $newRecord = new Partie_cache();
            $newRecord->id = $game_id;
            $newRecord->user_email = $lastRecord->user_email;
            $newRecord->user_username = $lastRecord->user_username;
            $newRecord->serie_id = $lastRecord->serie_id;
            $newRecord->tours = $nbRecord;
            $newRecord->distance = $distance;
            $newRecord->temps = $temps;
            $newRecord->difficulte = $lastRecord->difficulte;
            $newRecord->save();
            //Todo on va calculer les pts et delete de cette table maggle
            $TOTAL_T = 0;
            $record = Partie_cache::where("id", $game_id)->get();

            if ($lastRecord->difficulte == 1) $NORME_D = 200;
            if ($lastRecord->difficulte == 2) $NORME_D = 100;
            if ($lastRecord->difficulte == 3) $NORME_D = 50;
            foreach ($record as $r) {
                $SCORE_S = 0;
                //calcul de la hess selon l'énoncé avec une norme D à 100 mètre
                if ($r->distance == -1){
                    $SCORE_S = 0;
                } else if ($r->distance < $NORME_D) {
                    $SCORE_S = 5;
                } else if ($r->distance < 2 * $NORME_D) {
                    $SCORE_S = 3;
                } else if ($r->distance < 3 * $NORME_D) {
                    $SCORE_S = 1;
                }

                if ($r->tours == 0){
                    $SCORE_S = 0;
                }

                //calcul de la hess selon l'énoncé avec une norme T dans le sujet
                if ($r->temps < 20) {
                    $SCORE_S = $SCORE_S * 4;
                } else if ($r->temps < 50) {
                    $SCORE_S = $SCORE_S * 2;
                } else {
                    $SCORE_S = $SCORE_S * 0;
                }

                $TOTAL_T += $SCORE_S;
            }

            $finalRecord = new Partie();
            $finalRecord->id = $lastRecord->id;
            $finalRecord->user_email = $lastRecord->user_email;
            $finalRecord->user_username = $lastRecord->user_username;
            $finalRecord->score = $TOTAL_T;
            $finalRecord->difficulte = $lastRecord->difficulte;
            $finalRecord->serie_id = $lastRecord->serie_id;
            $finalRecord->save();

            $res=Partie_cache::where('id',$game_id)->delete();
            return 2;
        }

        if ($nbRecord > 0 && $nbRecord < 10) {
            //Todo la game continue
            $newRecord = new Partie_cache();
            $newRecord->id = $game_id;
            $newRecord->user_email = $lastRecord->user_email;
            $newRecord->user_username = $lastRecord->user_username;
            $newRecord->serie_id = $lastRecord->serie_id;
            $newRecord->tours = $nbRecord;
            $newRecord->distance = $distance;
            $newRecord->temps = $temps;
            $newRecord->difficulte = $lastRecord->difficulte;

            $newRecord->save();

            return 1;
        }
    }

    public function reCreateParty($id_game, $user_email, $user_username): array
    {
        $origin = Partie::where("id", $id_game)->first();

        $game_id = Uuid::uuid4();
        $partieCache = new Partie_cache();
        $partieCache->id = $game_id;
        $partieCache->user_email = $user_email;
        $partieCache->user_username = $user_username;
        $partieCache->serie_id = $origin->serie_id;
        $partieCache->tours = 0;
        $partieCache->distance = 0;
        $partieCache->difficulte = $origin->difficulte;
        $partieCache->temps = 0;
        $partieCache->save();

        $serie = $this->SsSerie->getSerieById($origin->serie_id);

        $schemaRecord = Partie_schema::where('partie_id', $id_game)->orderBy('tours', 'asc')->get();
        $serieA = [];
        foreach ($schemaRecord as $rec){
            $res = $this->SsSerie->getLocalisationById($rec->localisation_id);
            $serieA[] = $res;
        }

        return [
            "user_username" => $user_username,
            "user_email" => $user_email,
            "serie_id" => $serie->id,
            "serie_nom" => $serie->nom,
            "game_id" => $game_id,
            "startmap" => $serie->startmap,
            "localisations" => $serieA,
        ];
    }
}

