<?php

namespace geoquizz\service\app\actions;

use geoquizz\service\domain\services\SsPartie;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class PostCreatePartie extends AbstractAction
{
    private SsPartie $partieService;

    public function __construct(SsPartie $s)
    {
        $this->partieService = $s;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $client = new Client();
        //Uniquement récupérer le Header Authorization pour que le chargement dure pas 3 vies
        $authorization = $request->getHeader("Authorization");
        $headers = [
            "Authorization" => $authorization
        ];
        $encodeTokenRes = $client->request('GET', "http://auth_php/users/validate", ['headers' => $headers]);
        $tokenRes = json_decode($encodeTokenRes->getBody(), true);
        $parsedBody = json_decode($request->getBody(), true);
        $id = $tokenRes['email'];
        $username = $tokenRes['username'];
        $serie_id = $parsedBody['serie_id'];
        $difficulte = $parsedBody['difficulte'];

        $res = $this->partieService->createParty($serie_id, $id, $username, $difficulte);
        $response->getBody()->write(json_encode($res));

        return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
    }
}