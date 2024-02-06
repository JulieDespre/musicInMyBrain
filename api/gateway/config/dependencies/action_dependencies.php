<?php


use geoquizz\gate\app\actions\authentification\MethodAuthentificationAction;
use geoquizz\gate\app\actions\authentification\MethodGameAction;
use Psr\Container\ContainerInterface;

return[

    MethodAuthentificationAction::class => function (ContainerInterface $c){
        return new MethodAuthentificationAction($c->get('auth.client'));
    },

    MethodGameAction::class => function (ContainerInterface $c){
        return new MethodGameAction($c->get('game.client'));
    },

];