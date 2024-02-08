<?php


use geoquizz\service\app\actions\GetProfilAction;
use geoquizz\service\app\actions\PostCreatePartie;
use geoquizz\service\app\actions\SetProfilAction;
use geoquizz\service\app\actions\GetSerieAction;
use geoquizz\service\app\actions\GetSerieByIdAction;
use geoquizz\service\app\actions\GetHistoryAction;
use geoquizz\service\domain\services\SsPartie;
use geoquizz\service\domain\services\SsSerie;
use Psr\Container\ContainerInterface;

return[

    GetSerieAction::class => function (ContainerInterface $c){
        return new GetSerieAction($c->get('serie.service'));
    },

    GetSerieByIdAction::class => function (ContainerInterface $c){
        return new GetSerieByIdAction($c->get('serie.service'));
    },

    GetHistoryAction::class => function (ContainerInterface $c){
        return new GetHistoryAction($c->get('partie.service'));
    },

    PostCreatePartie::class => function (ContainerInterface $c){
        return new PostCreatePartie($c->get('partie.service'));
    },

    SsPartie::class => function (ContainerInterface $c){
        return new SsPartie($c->get('serie.service'));
    },

];