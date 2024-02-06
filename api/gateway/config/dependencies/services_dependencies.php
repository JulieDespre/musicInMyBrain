<?php


use geoquizz\gate\client\ClientApi;
use Psr\Container\ContainerInterface;

return [

    'auth.client' => function (ContainerInterface $c) {
        return new ClientApi(['base_uri' => 'http://auth_php', 'timeout' => 5.0]);
    },

];
