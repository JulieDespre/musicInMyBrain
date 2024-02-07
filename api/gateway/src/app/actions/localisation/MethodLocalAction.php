<?php

namespace geoquizz\gate\app\actions\localisation;

use geoquizz\gate\app\actions\AbstractAction;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class MethodLocalAction extends AbstractAction {


    private ClientApi $client;

    public function __construct(ClientApi $c) {
        $this->client = $c;
    }

    public function __invoke(Request $request, Response $response, $args): Response {
        $uri = $request->getUri()->getPath();
        $data = $this->client->get($uri,[
            'headers' => [
                'Authorization' => 'Bearer nQFzMw52tNnnSFLS8CmwLFLg-QYF263_',
            ]
        ]);
        $json = json_decode($data->getBody()->getContents(),true);
        $response->getBody()->write(json_encode($json,JSON_PRETTY_PRINT));

        return $response->withHeader('Content-Type', 'application/json');
    }

}