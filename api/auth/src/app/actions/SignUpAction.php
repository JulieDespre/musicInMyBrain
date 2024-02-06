<?php

namespace geoquizz\auth\app\actions;

use geoquizz\auth\domain\DTO\CredentialsDTO;
use geoquizz\auth\domain\exception\EmailFormatException;
use geoquizz\auth\domain\exception\RegisterExistException;
use geoquizz\auth\domain\exception\RegisterValueException;
use geoquizz\auth\domain\service\AuthServiceInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class SignUpAction extends AbstractAction {

    private AuthServiceInterface $authService;

    public function __construct(AuthServiceInterface $s) {
        $this->authService = $s;
    }

        public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
            $data = $request->getParsedBody();
            if (isset($data['email']) && isset($data['mdp']) && isset($data['pseudo'])) {
            $email = $data['email'];
            $mdp = $data['mdp'];
            $pseudo = $data['pseudo'];

            try {
                $userDTO = $this->authService->signup(new CredentialsDTO($email, $mdp, $pseudo));
                $data = [
                    'email' => $userDTO->email,
                    'pseudo' => $userDTO->username,
                ];
                $response->getBody()->write(json_encode($data));
                $response = $response->withStatus(200)->withHeader('Content-Type', 'application/json');
            } catch (RegisterValueException | RegisterExistException | EmailFormatException $e) {
                $responseMessage = array(
                    "message" => "401 Inscription failed",
                    "exception" => array(
                        "type" => $e::class,
                        "code" => $e->getCode(),
                        "message" => $e->getMessage(),
                        "file" => $e->getFile(),
                        "line" => $e->getLine()
                    )
                );
                $response->getBody()->write(json_encode($responseMessage));
                $response = $response->withStatus(401)->withHeader('Content-Type', 'application/json');
            }

        } else {
            $response->getBody()->write(json_encode(array("message" => "Données d'inscription incomplètes")));
            $response = $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }
        return $response;
    }
}