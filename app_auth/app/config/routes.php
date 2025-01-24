<?php
declare(strict_types=1);

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use app_auth\application\actions\AuthAction;
use app_auth\application\actions\CancelRDVAction;
use app_auth\application\actions\CreatePraticienAction;
use app_auth\application\actions\CreateRDVAction;
use app_auth\application\actions\GetPatientRDVAction;
use app_auth\application\actions\GetPraticienPlanningAction;
use app_auth\application\actions\GetRDVAction;
use app_auth\application\actions\HomeAction;
use app_auth\application\actions\UpdateRDVCycleAction;
use app_auth\application\middlewares\JWTAuthMiddleware;
use app_auth\application\middlewares\Cors;

return function( \Slim\App $app): \Slim\App {

    // Authentification
    $app->post('/users/signin[/]', AuthAction::class)->setName('signin');

    // Rafraîchir le token JWT
    $app->post('/users/refresh', AuthAction::class)->setName('refresh');
        // ->add(new JWTAuthMiddleware());

    return $app;
};
