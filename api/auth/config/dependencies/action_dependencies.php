<?php


use geoquizz\auth\app\actions\SignInAction;
use geoquizz\auth\app\actions\SignUpAction;
use geoquizz\auth\app\actions\UserRefreshAction;
use geoquizz\auth\app\actions\ValiderTokenJWTAction;
use Psr\Container\ContainerInterface;

return [
    SignInAction::class => function (ContainerInterface $c) {
        return new SignInAction($c->get('authenticate.service'));
    },

    SignUpAction::class => function (ContainerInterface $c) {
        return new SignUpAction($c->get('authenticate.service'));
    },
  
    ValiderTokenJWTAction::class => function (ContainerInterface $c) {
        return new ValiderTokenJWTAction($c->get('authenticate.service'));
    },

    UserRefreshAction::class => function (ContainerInterface $c){
        return new UserRefreshAction($c->get('authenticate.service'));
    },
];