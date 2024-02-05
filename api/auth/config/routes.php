<?php
declare(strict_types=1);

use pizzashop\auth\api\app\actions\SignInAction;
use pizzashop\auth\api\app\actions\ValiderTokenJWTAction;
use pizzashop\auth\api\app\actions\UserRefreshAction;

return function( \Slim\App $app):void {
    $app->post("/users/signin",SignInAction::class)->setName("signIn");
    $app->post("/users/signup",SignInAction::class)->setName("signup");
    $app->post('/users/refresh', UserRefreshAction::class)->setName('refreshUser');
    $app->get('/users/validate', ValiderTokenJWTAction::class)
        ->setName('validateTokenJWT');
};