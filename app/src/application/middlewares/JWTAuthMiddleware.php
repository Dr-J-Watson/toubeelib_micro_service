<?php

namespace toubeelib\application\middlewares;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException ;
use Firebase\JWT\BeforeValidException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use toubeelib\application\providers\auth\JWTAuthnProvider;
use toubeelib\core\dto\AuthDTO;

class JWTAuthMiddleware{

    public function __invoke(Request $rq, Response $rs, $next){
        try {
            $h = $rq->getHeader('Authorization')[0] ;
            $tokenstring = sscanf($h, "Bearer %s")[0];

            $token = JWTAuthnProvider::class->getSignedInUser($tokenstring);

            $auth = new AuthDTO($token->id, $token->email, $token->role);


        } catch (ExpiredException $e) {
            throw new \Exception("Token expired", 401);
        } catch (SignatureInvalidException $e) {
            throw new \Exception("Token invalid", 401);
        } catch (BeforeValidException $e) {
            throw new \Exception("Token not yet valid", 401);
        } catch (\UnexpectedValueException $e) {
            throw new \Exception(" invalid", 401);
        }

        $rq = $rq->withAttribute('auth', $auth);

        return $next->handle($rq);
    }
}