<?php


use Psr\Container\ContainerInterface;
use GuzzleHttp\Client;


return [

    'auth.client' => function (ContainerInterface $c) {
        return new Client(['base_uri' => 'http://auth_php']);
    },

    'game.client' => function (ContainerInterface $c) {
        return new Client(['base_uri' => 'http://service_geoquizz_php']);
    },

    'localisation.client' => function (ContainerInterface $c) {
        $directus = gethostbyname('directus');
        return new Client(['base_uri' => 'http://'.$directus.':8055']);
    },

];
