<?php

namespace geoquizz\gate\app\actions\authentification;

use geoquizz\gate\app\actions\AbstractAction;
use geoquizz\gate\client\ClientApi;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class MethodAuthentificationAction extends AbstractAction {

    private ClientApi $client;

    public function __construct(ClientApi $c) {
        $this->client = $c;
    }

    public function __invoke(Request $request, Response $response, $args): Response {
        $headers = $request->getHeaders();
        $method = $request->getMethod();
        $uri = $request->getUri()->getPath();
        $body = $request->getParsedBody();
        if ($method == 'GET'){
            $data = $this->client->get($uri,$body,$headers);
        }
        if ($method == 'POST'){
            $data = $this->client->post($uri,$body,$headers);
        }
        $response->getBody()->write($data);
        return $response->withHeader('Content-Type', 'application/json');
    }

}