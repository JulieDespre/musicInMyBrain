<?php

namespace geoquizz\gate\app\actions\localisation;

use geoquizz\gate\app\actions\AbstractAction;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class ImageLocalAction extends AbstractAction {


    private Client $client;

    public function __construct(Client $c) {
        $this->client = $c;
    }

    public function __invoke(Request $request, Response $response, $args): Response {
        $uri = $request->getUri()->getPath();
        $data = $this->client->get($uri,[
            'headers' => [
                'Authorization' => 'Bearer nQFzMw52tNnnSFLS8CmwLFLg-QYF263_',
            ]
        ]);
        $imageContent = $data->getBody()->getContents();
        $contentType = $data->getHeaderLine('Content-Type');
        $response->getBody()->write($imageContent);
        return $response->withHeader('Content-Type', $contentType);

    }

}