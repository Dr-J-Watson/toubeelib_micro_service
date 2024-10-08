<?php
declare(strict_types=1);

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

return function( \Slim\App $app):\Slim\App {

    $app->get('/', \toubeelib\application\actions\HomeAction::class)->setName('home');

    $app->get('/rdvs/{id}[/]', \toubeelib\application\actions\GetRDVAction::class)->setName('getRDV');

    $app->post('/rdv[/]', \toubeelib\application\actions\CreateRDVAction::class)->setName('createRDV');

    //cancel rdv 
    $app->patch('/rdvs/{id}/cancel[/]', \toubeelib\application\actions\CancelRDVAction::class)->setName('cancelRDV');

    // get pratitient disponibility between two dates

    $app->post('/praticien[/]', \toubeelib\application\actions\CreatePraticienAction::class)->setName('createPraticien');

    $app->get('/praticiens/{id}/planing[/]', \toubeelib\application\actions\GetPraticienPlanningAction::class)->setName('getPraticienDisponibility');
    //$app->get('/praticiens/{id}/planing[/]', \toubeelib\application\actions\GetPraticienPlanningAction::class)->setName('getPraticienDisponibility');

    return $app;
};