<?php

namespace geoquizz\service\domain\services;

use geoquizz\service\domain\DTO\LocalisationDTO;
use geoquizz\service\domain\DTO\SerieDTO;
use geoquizz\service\domain\entities\Serie;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class SsSerie
{

    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @throws GuzzleException
     */
    public function getSerie()
    {
        $encodeRes = $this->client->get("/items/serie");
        $res = json_decode($encodeRes->getBody(), true);
        $tab = [];
        foreach ($res['data'] as $r){
            $tab[] = new SerieDTO($r['id'], $r['nom'], $r['photo']);
        }
        return $tab;
    }

    public function getSerieById(int $id)
    {
        $encodeRes = $this->client->get("/items/serie/".$id);
        $r = json_decode($encodeRes->getBody(), true);
        return new SerieDTO($r['data']['id'], $r['data']['nom'], $r['data']['photo'], $r['data']['startmap']['coordinates']);
    }

    public function getLocalisationBySerie(int $id_serie){
        $tab = [];
        $encodeRes = $this->client->get('/items/serie/'.$id_serie);
        $res = json_decode($encodeRes->getBody(), true);

        $tableau_id = $res['data']['localisation'];
        $host = gethostbyname("directus");

        foreach ($tableau_id as $tdi){
            $encodeResDeux = $this->client->get('/items/localisation/'.$tdi);
            $resDeux = json_decode($encodeResDeux->getBody(), true);

            $tab[] = new LocalisationDTO($resDeux['data']['id'], $resDeux['data']['lieu'],"http://docketu.iutnc.univ-lorraine.fr:35200/assets/".$resDeux['data']['photo'], $resDeux['data']['coordonnee']['coordinates']);
        }
        return $tab;
    }

    public function getLocalisationById(int $id){
            $encodeResDeux = $this->client->get('/items/localisation/'.$id);
            $resDeux = json_decode($encodeResDeux->getBody(), true);

            $res = new LocalisationDTO($resDeux['data']['id'], $resDeux['data']['lieu'],"http://docketu.iutnc.univ-lorraine.fr:35200/assets/".$resDeux['data']['photo'], $resDeux['data']['coordonnee']['coordinates']);
        return $res;
    }
}