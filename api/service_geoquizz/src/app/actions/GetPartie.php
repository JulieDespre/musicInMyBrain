<?php

namespace geoquizz\service\app\actions;

use geoquizz\service\domain\services\SsPartie;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetPartie extends AbstractAction
{
    private SsPartie $partieService;

    public function __construct(SsPartie $s)
    {
        $this->partieService = $s;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $res = $this->partieService->getGames();
        $response->getBody()->write(json_encode($res));

        return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
    }
}