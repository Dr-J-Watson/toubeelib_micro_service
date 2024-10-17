<?php
declare(strict_types=1);

use toubeelib\application\actions\AuthAction;
use toubeelib\application\actions\CancelRDVAction;
use toubeelib\application\actions\CreatePraticienAction;
use toubeelib\application\actions\CreateRDVAction;
use toubeelib\application\actions\GetPatientRDVAction;
use toubeelib\application\actions\GetPraticienPlanningAction;
use toubeelib\application\actions\GetRDVAction;
use toubeelib\application\actions\HomeAction;
use toubeelib\application\actions\UpdateRDVCycleAction;
use toubeelib\application\middlewares\JWTAuthMiddleware;

return function( \Slim\App $app):\Slim\App {

    $app->get('/', HomeAction::class)->setName('home');

    $app->get('/rdvs/{id}[/]', GetRDVAction::class)->setName('getRDV')
        ->add(new JWTAuthMiddleware());

    $app->post('/rdvs/create[/]', CreateRDVAction::class)->setName('createRDV');

    //cancel rdv
    $app->patch('/rdvs/{id}/cancel[/]', CancelRDVAction::class)->setName('cancelRDV');

    // get pratitient disponibility between two dates

    $app->post('/praticien/create[/]', CreatePraticienAction::class)->setName('createPraticien');

    $app->get('/praticiens/{id}/planing[/]', GetPraticienPlanningAction::class)->setName('getPraticienDisponibility')
        ->add(new JWTAuthMiddleware());

    $app->get('/patients/{patient_id}/rdvs[/]', GetPatientRDVAction::class)->setName('getPatientRDV')
        ->add(new JWTAuthMiddleware());

    //gérer le cycle de vie des rendez-vous (honoré, non honoré, payé)
    $app->patch('/rdvs/{id}/cycle[/]', UpdateRDVCycleAction::class)->setName('updateRDVCycle');

    //Auth
    $app->post('/users/signin[/]', AuthAction::class)->setName('signin');

    //Refresh token
    $app->post('/refresh', AuthAction::class)->setName('refresh')
        ->add(new JWTAuthMiddleware());


    return $app;
};
