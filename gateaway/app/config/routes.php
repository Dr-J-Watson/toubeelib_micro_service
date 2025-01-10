<?php
declare(strict_types=1);

use gateway\application\middlewares\Cors;
use gateway\application\actions\HomeAction;
use gateway\application\actions\GenericPraticienAction;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;



return function( \Slim\App $app): \Slim\App {

    // Ajout du middleware CORS
    $app->add(Cors::class);

    // Options route pour CORS
    $app->options('/{routes:.+}', function (Request $rq, Response $rs, array $args) : Response {
        return $rs;
    });

    // Routes
    $app->get('/', HomeAction::class)->setName('home');

    $app->get('/praticiens[/]', GenericPraticienAction::class)->setName('getPraticiens');
    $app->get('/praticiens/{id}[/]', GenericPraticienAction::class)->setName('getPraticien');
    $app->get('/praticiens/{id}/planing[/]', GenericPraticienAction::class)->setName('getPraticienPlanning');


    return $app;
};
