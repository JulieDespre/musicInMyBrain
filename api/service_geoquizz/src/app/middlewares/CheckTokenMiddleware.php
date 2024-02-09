<?php

namespace geoquizz\service\app\middlewares;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Exception\HttpUnauthorizedException;

class CheckTokenMiddleware
{
    public function __invoke($request, $handler)
    {

        //Uniquement récupérer le Header Authorization pour que le chargement dure pas 3 vies
        $authorization = $request->getHeader("Authorization");
        $headers = [
            "Authorization" => $authorization
        ];

        $client = new Client();
        try {
            $client->request('GET', "http://auth_php/users/validate", ['headers' => $headers]);
            $response = $handler->handle($request);
        } catch (ClientException $e) {
            throw new HttpUnauthorizedException($request, "Token invalide");
        }
        return $response;
    }
}