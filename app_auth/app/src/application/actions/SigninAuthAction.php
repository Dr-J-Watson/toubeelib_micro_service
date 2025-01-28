<?php

namespace app_auth\application\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use app_auth\application\providers\auth\JWTAuthnProvider;
use app_auth\core\dto\AuthDTO;
use app_auth\core\dto\CredentialsDTO;

class SigninAuthAction extends AbstractAction{

    public function __invoke(Request $rq, Response $rs, $args): Response{




        return $rs;
    }
}