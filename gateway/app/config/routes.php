<?php
declare(strict_types=1);

use gateway\application\middlewares\Cors;
use gateway\application\middlewares\AuthMiddleware;
use gateway\application\actions\HomeAction;
use gateway\application\actions\GenericPraticienAction;
use gateway\application\actions\GenericAuthAction;
use gateway\application\actions\GenericRdvAction;
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

    // Praticiens
    $app->get('/praticiens[/]', GenericPraticienAction::class)->setName('getPraticiens');
    $app->get('/praticiens/{id}[/]', GenericPraticienAction::class)->setName('getPraticien');
    $app->get('/praticiens/{id}/planing[/]', GenericRdvAction::class)->setName('getPraticienPlanning')
        ->add(AuthMiddleware::class);

    $app->get('/praticiens/{id}/planing[/]', GenericRdvAction::class)->setName('getPraticienPlanning');
    $app->get('/praticiens/{id}/disponibility[/]', GenericRdvAction::class)->setName('getPraticienDispobilite');

    //Authentification
    $app->post('/users/signin[/]', GenericAuthAction::class)->setName('signin');
    $app->post('/users/register[/]', GenericAuthAction::class)->setName('register');
    $app->post('/users/refresh[/]', GenericAuthAction::class)->setName('refresh')
        ->add(AuthMiddleware::class);

    //RDV
    $app->get('/rdvs[/]', GenericRdvAction::class)->setName('getRDVs')
        ->add(AuthMiddleware::class);
    $app->get('/rdvs/{id}[/]', GenericRdvAction::class)->setName('getRDV')
        ->add(AuthMiddleware::class);
    $app->post('/rdvs[/]', GenericRdvAction::class)->setName('createRDV')
        ->add(AuthMiddleware::class);

    return $app;
};
