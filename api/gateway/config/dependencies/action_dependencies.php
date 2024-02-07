<?php


use geoquizz\gate\app\actions\authentification\MethodAuthentificationAction;
use geoquizz\gate\app\actions\game\MethodGameAction;
use geoquizz\gate\app\actions\localisation\ImageLocalAction;
use geoquizz\gate\app\actions\localisation\MethodLocalAction;
use Psr\Container\ContainerInterface;

return[

    MethodAuthentificationAction::class => function (ContainerInterface $c){
        return new MethodAuthentificationAction($c->get('auth.client'));
    },

    MethodGameAction::class => function (ContainerInterface $c){
        return new MethodGameAction($c->get('game.client'));
    },

    MethodLocalAction::class => function (ContainerInterface $c){
        return new MethodLocalAction($c->get('localisation.client'));
    },

    ImageLocalAction::class => function (ContainerInterface $c){
        return new ImageLocalAction($c->get('localisation.client'));
    },



];