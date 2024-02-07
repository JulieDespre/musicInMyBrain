<?php

namespace geoquizz\service\app\middlewares;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Exception\HttpUnauthorizedException;

class CheckToken implements \Psr\Http\Server\MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = $handler->handle($request);
        $headers = $request->getHeaders();

        $client = new Client();
        try {
            $res = $client->request('GET', "http://auth_php/users/validate", ['headers' => $headers]);
            $request->withAttribute('tokenValidationResult', $res);
        } catch (ClientException $e) {
            throw new HttpUnauthorizedException($request, "Token invalide");
        } catch (GuzzleException $e) {
        }
        return $response;
    }
}