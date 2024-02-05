<?php
declare(strict_types=1);


use pizzashop\gate\app\actions\authentification\MethodAuthentificationAction;
use pizzashop\gate\app\actions\catalogue\GetCatalogue;
use pizzashop\gate\app\actions\commande\AccederCommandeAction;
use pizzashop\gate\app\actions\commande\CreerCommandeAction;
use pizzashop\gate\app\actions\commande\ValiderCommandeAction;

return function(\Slim\App $app):void {



    //CORS
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