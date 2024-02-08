<?php


use GuzzleHttp\Client;
use Psr\Container\ContainerInterface;

return [

    'auth.client' => function (ContainerInterface $c) {
        return new Client(['base_uri' => 'http://auth_php']);
    },

    'game.client' => function (ContainerInterface $c) {
        $geoquizz = gethostbyname('service_geoquizz_php');
        return new Client(['base_uri' => 'http://'.$geoquizz]);
    },

    'localisation.client' => function (ContainerInterface $c) {
        $directus = gethostbyname('directus');
        return new Client(['base_uri' => 'http://'.$directus.':8055']);
    },

];
