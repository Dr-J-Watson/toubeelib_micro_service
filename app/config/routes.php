<?php
declare(strict_types=1);

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

return function( \Slim\App $app):\Slim\App {

    $app->add(toubeelib\application\middlewares\Cors::class);

    $app->options('/{routes:.+}',
        function( Request $rq, Response $rs, array $args) : Response {
            return $rs;
        });

    $app->get('/', \toubeelib\application\actions\HomeAction::class)->setName('home');

    $app->get('/rdvs/{id}[/]', \toubeelib\application\actions\GetRDVAction::class)->setName('getRDV');

    $app->post('/rdvs[/]', \toubeelib\application\actions\CreateRDVAction::class)->setName('createRDV');

    //cancel rdv
    $app->patch('/rdvs/{id}/cancel[/]', \toubeelib\application\actions\CancelRDVAction::class)->setName('cancelRDV');

    $app->get('/praticiens[/]', \toubeelib\application\actions\GetPraticiensAction::class)->setName('getPraticiens');

    $app->get('/praticiens/{id}[/]', \toubeelib\application\actions\GetPraticienAction::class)->setName('getPraticien');

    $app->get('/praticiens/{id}/disponibility[/]', \toubeelib\application\actions\GetPraticienDisponibilityAction::class)->setName('getPraticienDisponibility');

    $app->post('/praticiens[/]', \toubeelib\application\actions\CreatePraticienAction::class)->setName('createPraticien');

    $app->get('/praticiens/{id}/planing[/]', \toubeelib\application\actions\GetPraticienPlanningAction::class)->setName('getPraticienPlanning');

    $app->get('/patients/{patient_id}/rdvs[/]', \toubeelib\application\actions\GetPatientRDVAction::class)->setName('getPatientRDV');

    //gérer le cycle de vie des rendez-vous (honoré, non honoré, payé)
    $app->patch('/rdvs/{id}/cycle[/]', \toubeelib\application\actions\UpdateRDVCycleAction::class)->setName('updateRDVCycle');

    return $app;
};