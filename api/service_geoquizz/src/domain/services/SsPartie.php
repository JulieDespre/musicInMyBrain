<?php

namespace geoquizz\service\domain\services;

use geoquizz\service\domain\DTO\PartieDTO;
use geoquizz\service\domain\entities\Partie;
use geoquizz\service\domain\entities\Partie_cache;
use GuzzleHttp\Client;
use Ramsey\Uuid\Uuid;

class SsPartie
{
    public function getHistory($user_id)
    {
        $parties = Partie::where("user_id", $user_id)->get();
        $tab = [];
        foreach ($parties as $p) {
            $tab[] = new PartieDTO($p->id, $p->user_id, $p->score, $p->difficulte, $p->serie_id);
        }
        return $tab;
    }

    public function createParty($serie_id, $user_email, $user_username)
    {
        $game_id = Uuid::uuid4();
        $partieCache = new Partie_cache();
        $partieCache->id = $game_id;
        $partieCache->user_email = $user_email;
        $partieCache->user_username = $user_username;
        $partieCache->serie_id = $serie_id;
        $partieCache->tours = 0;
        $partieCache->distance = 0;
        $partieCache->temps = 0;

        $directus = gethostbyname('directus');
        $ssSerie = new SsSerie(new Client(['base_uri' => 'http://' . $directus . ':8055', 'timeout' => 5.0]));
        $localisation = $ssSerie->getLocalisationBySerie($serie_id);

        $partieCache->save();

        return [
            "game_id" => $game_id,
            "localisations" => $localisation,
        ];
    }

    public function playParty($game_id, $distance, $temps)
    {
        $record = Partie_cache::where("id", $game_id)->get();
        $nbRecord = $record->count();
        var_dump($nbRecord);
        $lastRecord = Partie_cache::where("id", $game_id)->latest("tours")->first();

        if ($nbRecord == 0) {
            throw new \Exception("Partie non existante");
        }

        if ($nbRecord >= 11) {
            throw new \Exception("Normalement la partie aurait du finir si ce message s'affiche c'est la faute de moi");
        }

        if ($nbRecord == 10) {
            //Todo Ajout
            $newRecord = new Partie_cache();
            $newRecord->id = $game_id;
            $newRecord->user_email = $lastRecord->user_email;
            $newRecord->user_username = $lastRecord->user_username;
            $newRecord->serie_id = $lastRecord->serie_id;
            $newRecord->tours = $nbRecord;
            $newRecord->distance = $distance;
            $newRecord->temps = $temps;
            $newRecord->save();
            //Todo on va calculer les pts et delete de cette table maggle
            $TOTAL_T = 0;
            $record = Partie_cache::where("id", $game_id)->get();
            $NORME_D = 100;
            foreach ($record as $r) {
                $SCORE_S = 0;
                //calcul de la hess selon l'énoncé avec une norme D à 100 mètre
                if ($r->distance < $NORME_D) {
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
                if ($r->temps < 5) {
                    $SCORE_S = $SCORE_S * 4;
                } else if ($r->temps < 10) {
                    $SCORE_S = $SCORE_S * 2;
                } else {
                    $SCORE_S = $SCORE_S * 0;
                }

                $TOTAL_T += $SCORE_S;
            }

            $finalRecord = new Partie();
            $finalRecord->user_email = $lastRecord->user_email;
            $finalRecord->user_username = $lastRecord->user_username;
            $finalRecord->score = $TOTAL_T;
            $finalRecord->difficulte = 1;
            $finalRecord->serie_id = $lastRecord->serie_id;
            $finalRecord->save();

            $res=Partie_cache::where('id',$game_id)->delete();
            return true;
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

            $newRecord->save();

            return true;
        }
    }
}

