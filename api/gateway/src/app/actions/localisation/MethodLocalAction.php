<?php

namespace geoquizz\gate\app\actions\localisation;

use geoquizz\gate\app\actions\AbstractAction;
use geoquizz\gate\client\ClientApi;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class MethodLocalAction extends AbstractAction {

    private ClientApi $client;

    public function __construct(ClientApi $c) {
        $this->client = $c;
    }

    public function __invoke(Request $request, Response $response, $args): Response {
        $uri = $request->getUri()->getPath();
        $data = $this->client->get($uri);
        $response->getBody()->write($data);
        return $response->withHeader('Content-Type', 'application/json');
    }

}