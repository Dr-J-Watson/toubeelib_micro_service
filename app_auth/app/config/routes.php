<?php
declare(strict_types=1);

use app_auth\application\actions\RefreshTokenAuthAction;
use app_auth\application\actions\SigninAuthAction;
use app_auth\application\actions\ValidateTokenAuthAction;

//use app_auth\application\actions\HomeAction;

return function( \Slim\App $app): \Slim\App {

    // Authentification
    $app->post('/users/signin[/]', SigninAuthAction::class)->setName('signin');

    // Rafraîchir le token JWT
    $app->post('/users/refresh', RefreshTokenAuthAction::class)->setName('refresh');

    $app->post('/users/validate', ValidateTokenAuthAction::class)->setName('refresh');
    return $app;
};
