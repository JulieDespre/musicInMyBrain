<?php

namespace geoquizz\auth\domain\service;

use DateTime;
use DomainException;
use geoquizz\auth\app\auth\managers\JwtManager;
use geoquizz\auth\app\auth\providers\AuthProvider;
use geoquizz\auth\domain\dto\CredentialsDTO;
use geoquizz\auth\domain\dto\TokenDTO;
use geoquizz\auth\domain\DTO\UserDTO;
use geoquizz\auth\domain\entities\Users;
use geoquizz\auth\domain\exception\ActivationTokenExpiredException;
use geoquizz\auth\domain\exception\AuthServiceExpiredTokenException;
use geoquizz\auth\domain\exception\AuthServiceInvalideTokenException;
use geoquizz\auth\domain\exception\EmailFormatException;
use geoquizz\auth\domain\exception\InvalidActivationTokenException;
use geoquizz\auth\domain\exception\JwtExpiredException;
use geoquizz\auth\domain\exception\JwtInvalidException;

class AuthService implements AuthServiceInterface {
    private JwtManager $jwtManager;
    private AuthProvider $authProvider;

    public function __construct(JwtManager $jwtManager, AuthProvider $authProvider) {
        $this->jwtManager = $jwtManager;
        $this->authProvider = $authProvider;
    }

    /**
     * @inheritDoc
     * @throws EmailFormatException
     */
    public function signup(CredentialsDTO $credentialsDTO): UserDTO {
        //sanitize
        $email = filter_var($credentialsDTO->email, FILTER_SANITIZE_EMAIL);
        //validate
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            throw new EmailFormatException();
        }


        $username = filter_var($credentialsDTO->username, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z]+$/")));


        $this->authProvider->register($email, $credentialsDTO->password, $username);
        return new UserDTO($email,$username);
    }

    /**
     * @inheritDoc
     */
    public function signin(CredentialsDTO $credentialsDTO): TokenDTO {
        $this->authProvider->checkCredentials($credentialsDTO->email,$credentialsDTO->password);
        return $this->authProvider->genToken($this->authProvider->getUser($credentialsDTO->email,''), $this->jwtManager);
    }

    /**
     * @inheritDoc
     */
    public function validate(TokenDTO $tokenDTO): UserDTO {
        try {
        $payload = $this->jwtManager->validate($tokenDTO->jwt);
        }catch (JwtExpiredException $e){
            throw new AuthServiceExpiredTokenException;
        }catch (JwtInvalidException | DomainException $e) {
            throw new AuthServiceInvalideTokenException;
        }
        return new UserDTO($payload->upr->email, $payload->upr->username);
    }

    /**
     * @inheritDoc
     */
    public function refresh(TokenDTO $tokenDTO): TokenDTO {
        $this->authProvider->checkToken($tokenDTO->refreshToken);
        return $this->authProvider->genToken($this->authProvider->getUser('',$tokenDTO->refreshToken), $this->jwtManager);
    }

    /**
     * @inheritDoc
     */
    public function activate_signup(TokenDTO $tokenDTO): void {
        // Récupérez l'utilisateur associé au jeton d'activation
        $user = Users::where('activation_token', $tokenDTO->activationToken)->firstOrFail();

        if ($user && !$user->active) {
            $now = new DateTime();
            $tokenExpDate = new DateTime($user->activation_token_expiration_date);

            if ($tokenExpDate > $now) {
                // Le jeton d'activation est valide, activez le compte de l'utilisateur
                $user->active = true;
                $user->save();
            } else {
                throw new ActivationTokenExpiredException();
            }
        } else {
            throw new InvalidActivationTokenException();
        }
    }
}