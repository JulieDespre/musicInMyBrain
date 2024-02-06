<?php


use geoquizz\gate\client\ClientApi;
use Psr\Container\ContainerInterface;

return [

    'auth.client' => function (ContainerInterface $c) {
        return new ClientApi(['base_uri' => 'http://auth_php', 'timeout' => 5.0]);
    },

    'game.client' => function (ContainerInterface $c) {
        return new ClientApi(['base_uri' => 'http://service_geoquizz_php', 'timeout' => 5.0]);
    },

    'localisation.client' => function (ContainerInterface $c) {
        $directus = gethostbyname('directus');
        return new ClientApi(['base_uri' => 'http://'.$directus.':8055', 'timeout' => 5.0]);
    },

];
