<?php

namespace geoquizz\auth\app\auth\providers;


use DateTime;
use DateTimeZone;
use Exception;
use geoquizz\auth\app\auth\managers\JwtManager;
use geoquizz\auth\domain\dto\CredentialsDTO;
use geoquizz\auth\domain\dto\TokenDTO;
use geoquizz\auth\domain\entities\Users;
use geoquizz\auth\domain\exception\AuthServiceInvalideDonneeException;
use geoquizz\auth\domain\exception\CredentialsException;
use geoquizz\auth\domain\exception\RefreshTokenInvalideException;
use geoquizz\auth\domain\exception\RefreshUtilisateurException;
use geoquizz\auth\domain\exception\SignInException;

class AuthProvider
{
    private Users $currentAuthenticatedUser;

    public function checkCredentials(string $email, string $pass): void
    {
        try {
            $user = Users::where('email', $email)->firstOrFail();

            if (!password_verify($pass, $user->password)) {
                throw new CredentialsException();
            }
        } catch (Exception $e) {
            throw new CredentialsException();
        }
    }

    public function register(string $user, string $pass): void
    {
        try {
            $credentialsDTO = new CredentialsDTO();
            $credentialsDTO->email = $user;
            $credentialsDTO->password = $pass;

            $this->authService->signup($credentialsDTO);
        } catch (Exception $e) {
            throw new AuthServiceInvalideDonneeException();
        }
    }

    public function activate(string $token): void
    {
        $t = new TokenDTO($token);
        try {
            $this->authService->activate_signup($t);
        } catch (Exception $e) {
            throw new AuthServiceInvalideDonneeException();
        }
    }

    public function getAuthenticatedUser(): array
    {
        return [
            'username' => $this->currentAuthenticatedUser->username,
            'email' => $this->currentAuthenticatedUser->email,
            'refresh_token' => $this->currentAuthenticatedUser->refresh_token,
        ];
    }


    /**
     * Vérifie si un token est présent dans la bd pour un utilisateur
     *
     * @param string $token le token à vérifier
     * @return void
     * @throws RefreshTokenInvalideException si le token est introuvable en bd ou dépassé
     */
    public function checkToken(string $token)
    {
        try {
            $user = Users::where('refresh_token', $token)->firstOrFail();
            $tokenExpDate = new DateTime($user->refresh_token_expiration_date);
            $now = new DateTime('now', new DateTimeZone('Europe/Paris'));

            if ($tokenExpDate->getTimestamp() < $now->getTimestamp()) {
                throw new RefreshTokenInvalideException();
            }
        } catch (Exception $e) {
            throw new RefreshTokenInvalideException();
        }
    }


    public function genToken(Users $user, JwtManager $jwtManager): TokenDTO
    {
        $newRefreshToken = bin2hex(random_bytes(32));
        $now = new DateTime('now', new DateTimeZone('Europe/Paris'));
        $refreshTokenExpDate = $now->modify('+1 hour');

        $user->refresh_token = $newRefreshToken;
        $user->refresh_token_expiration_date = $refreshTokenExpDate->format('Y-m-d H:i:s');
        $user->save();

        $token = $jwtManager->create(['username' => $user->username, 'email' => $user->email]);
        return new TokenDTO($newRefreshToken, $token);
    }

    public function getUser(string $email, string $token): Users
    {
        if ($email == '') {
            try {
                return Users::where('refresh_token', $token)->firstOrFail();
            } catch (Exception $e) {
                throw new RefreshUtilisateurException();
            }
        } else {
            try {
                return Users::where('email', $email)->firstOrFail();
            } catch (Exception $e) {
                throw new SignInException();
            }
        }

    }

}