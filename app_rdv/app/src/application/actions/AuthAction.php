<?php

namespace app_rdv\application\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use toubeelib\application\providers\auth\JWTAuthnProvider;
use toubeelib\core\dto\AuthDTO;
use toubeelib\core\dto\CredentialsDTO;

class AuthAction extends AbstractAction{

    public function __invoke(Request $rq, Response $rs, $args): Response{

        if($rq->getUri()->getPath() == '/refresh'){ //Refresh token
            $h = $rq->getHeader('Authorization')[0] ;
            $token = sscanf($h, "Bearer %s")[0];
            try{
                $auth = JWTAuthnProvider::class->refresh($token);
                $responseBody = [
                    'atoken' => $auth->token,
                    'rtoken' => $auth->refreshToken
                ];

                $rs->getBody()->write(json_encode($responseBody));
                return $rs->withStatus(201)
                    ->withHeader('Content-Type', 'application/json');

            } catch (\Exception $e) {
                $rs->getBody()->write($e->getMessage());
                return $rs->withStatus(401);
            }


        }else { //Signin
            $data = $rq->getHeader('Authorization')[0];
            $authData = str_replace('Basic ', '', $data);

            // Décodage de la chaîne Base64
            $decodedData = base64_decode($authData);

            // Séparation des informations username:password
            list($username, $password) = explode(':', $decodedData);

            if (!isset($username) || !isset($password)) {
                $rs->getBody()->write('Email and password are required.');
                return $rs->withStatus(400);
            }

            $credentials = new CredentialsDTO($username, $password);

            try {
                $jwtAuthnProvider = new JWTAuthnProvider();
                $auth = $jwtAuthnProvider->signin($credentials);
                $responseBody = [
                    'atoken' => $auth->token,
                    'rtoken' => $auth->refreshToken
                ];

                $rs->getBody()->write(json_encode($responseBody));
                return $rs->withStatus(201)
                    ->withHeader('Content-Type', 'application/json');

            } catch (\Exception $e) {
                $rs->getBody()->write($e->getMessage());
                return $rs->withStatus(401);
            }
        }
    }
}