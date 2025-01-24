<?php

namespace app_auth\application\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use app_auth\application\providers\auth\JWTAuthnProvider;
use app_auth\core\dto\AuthDTO;
use app_auth\core\dto\CredentialsDTO;

class AuthAction extends AbstractAction{

    public function __invoke(Request $rq, Response $rs, $args): Response{

        if($rq->getUri()->getPath() == '/users/refresh'){ //Refresh token
            
            $header = $rq->getHeader('Authorization');

            $token = $header[0] ?? null;

            if(is_null($token)){
                $rs->getBody()->write('Refresh token is required');
                return $rs->withStatus(400);
            }

            try{
                $auth = new JWTAuthnProvider();
                $auth = $auth->refresh($token);
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
            $body = $rq->getParsedBody();
            $email = $body['email'] ?? null;
            $password = $body['password'] ?? null;

            if (is_null($email) || is_null($password)) {
                $rs->getBody()->write('Email and password are required');
                return $rs->withStatus(400);
            }

            $credentials = new CredentialsDTO($email, $password);

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