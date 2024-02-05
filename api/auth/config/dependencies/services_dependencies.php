<?php

use geoquizz\auth\app\auth\managers\JwtManager;
use geoquizz\auth\app\auth\providers\AuthProvider;
use geoquizz\auth\domain\service\AuthService;
use Psr\Container\ContainerInterface;

return[

    'jwt.manager' => function (ContainerInterface $c) {
        return new JwtManager();
    },

    'authenticate.provider' => function (ContainerInterface $c) {
        return new AuthProvider();
    },

    'authenticate.service' => function (ContainerInterface $c) {
        return new AuthService($c->get('jwt.manager'),$c->get('authenticate.provider'));
    },
];