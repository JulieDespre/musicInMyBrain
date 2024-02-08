<?php


use geoquizz\service\domain\services\SsSerie;
use geoquizz\service\domain\services\SsPartie;
use GuzzleHttp\Client;
use Psr\Container\ContainerInterface;

return [
    'serie.service' => function (ContainerInterface $c) {
        $directus = gethostbyname('directus');
        return new SsSerie(new Client(['base_uri' => 'http://'.$directus.':8055']));
    },
    'partie.service' => function (ContainerInterface $c) {
        $directus = gethostbyname('directus');
        return new SsPartie(new SsSerie(new Client(['base_uri' => 'http://'.$directus.':8055'])));
    },
];