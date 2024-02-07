<?php
declare(strict_types=1);

use geoquizz\service\app\actions\GetHistoryAction;
use geoquizz\service\app\actions\GetProfilAction;
use geoquizz\service\app\actions\SetProfilAction;
use geoquizz\service\app\actions\GetSerieAction;
use geoquizz\service\app\actions\GetSerieByIdAction;
use geoquizz\service\app\actions\PostTourPartie;
use geoquizz\service\app\actions\PostCreatePartie;
use geoquizz\service\app\middlewares\CheckToken;


return function( \Slim\App $app):void {

    $app->get('/serie[/]', GetSerieAction::class)
        ->setName('getserie');

    $app->get('/serie/{id_serie}[/]', GetSerieByIdAction::class)
        ->setName('getidserie');

    $app->get('/historique[/]', GetHistoryAction::class)
        ->setName('historique');

    $app->post("/games/create",PostCreatePartie::class)
        ->addMiddleware(new CheckToken());

    $app->post("/games/play",PostTourPartie::class)
        ->addMiddleware(new CheckToken());

    $app->options('/{routes:.+}', function ($request, $response, $args) {
        return $response; // Renvoie une réponse HTTP vide
    });

    $app->add(function ($request, $handler) {
        $response = $handler->handle($request);
        if (!$request->hasHeader('Origin')) {
            $origin = '*';
        } else {
            $origin = $request->getHeader('Origin');
        }
        return $response
            ->withHeader('Access-Control-Allow-Origin', $origin)
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS')
            ->withHeader('Access-Control-Allow-Credentials', 'true');
    });
};