<?php

namespace app_auth\application\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use app_auth\application\providers\auth\JWTAuthnProvider;
use app_auth\core\dto\AuthDTO;
use app_auth\core\dto\CredentialsDTO;

class ValidateTokenAuthAction extends AbstractAction{

    public function __invoke(Request $rq, Response $rs, $args): Response{

        $h = $rq->getHeader('Authorization')[0] ;
        $token = sscanf($h, "Bearer %s")[0] ?? null ;

        if (is_null($token)) {
            $rs->getBody()->write('Token is required');
            return $rs->withStatus(400);
        }
        try {
            $jwtAuthnProvider = new JWTAuthnProvider();
            $payload = $jwtAuthnProvider->getSignedInUser($token);
            $responseBody = [
                'valid' => true,
                'data' => [
                    "mail" => $payload->email,
                    "role" => $payload->role
                ]
            ];

            $rs->getBody()->write(json_encode($responseBody));
            return $rs->withStatus(200)
                ->withHeader('Content-Type', 'application/json');

        } catch (\Exception $e) {
            $rs->getBody()->write(json_encode(['valid' => false, 'error' => $e->getMessage()]));
            return $rs->withStatus(401)
                ->withHeader('Content-Type', 'application/json');
        }
    }
}