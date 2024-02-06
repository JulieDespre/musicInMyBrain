<?php
declare(strict_types=1);

use geoquizz\auth\app\actions\SignInAction;
use geoquizz\auth\app\actions\SignUpAction;
use geoquizz\auth\app\actions\UserRefreshAction;
use geoquizz\auth\app\actions\ValiderTokenJWTAction;

return function( \Slim\App $app):void {
    $app->post("/signin",SignInAction::class)->setName("signIn");
    $app->post("/signup",SignUpAction::class)->setName("signup");
    $app->post('/users/refresh', UserRefreshAction::class)->setName('refreshUser');
    $app->get('/users/validate', ValiderTokenJWTAction::class)
        ->setName('validateTokenJWT');
};