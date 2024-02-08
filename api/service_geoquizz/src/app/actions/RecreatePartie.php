<?php

namespace geoquizz\service\app\actions;

use geoquizz\service\domain\entities\Partie_cache;
use geoquizz\service\domain\services\SsPartie;
use geoquizz\service\domain\services\SsProfile;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class RecreatePartie extends AbstractAction
{
    private SsPartie $partieService;

    public function __construct(SsPartie $s)
    {
        $this->partieService = $s;
    }

    /**
     * @throws GuzzleException
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $client = new Client();
        $headers = $request->getHeaders();
        $encodeTokenRes = $client->request('GET', "http://auth_php/users/validate", ['headers' => $headers]);
        $tokenRes = json_decode($encodeTokenRes->getBody(), true);
        $id = $tokenRes['email'];
        $username = $tokenRes['username'];
        $game_id = $args['id_partie'];

        $res = $this->partieService->reCreateParty($game_id, $id, $username);
        $response->getBody()->write(json_encode($res));

        return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
    }
}