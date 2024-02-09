<?php

namespace geoquizz\service\app\actions;

use geoquizz\service\domain\services\SsSerie;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetSerieAction extends AbstractAction
{
    private SsSerie $serieService;

    public function __construct(SsSerie $s)
    {
        $this->serieService = $s;
    }
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $series = $this->serieService->getSerie();
        $response->getBody()->write(json_encode($series));

        return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
    }
}