<?php
declare(strict_types=1);

use app_rdv\application\actions\CancelRDVAction;
use app_rdv\application\actions\CreateRDVAction;
use app_rdv\application\actions\GetPatientRDVAction;
use app_rdv\application\actions\GetPraticienPlanningAction;
use app_rdv\application\actions\GetRDVAction;
use app_rdv\application\actions\HomeAction;
use app_rdv\application\actions\UpdateRDVCycleAction;

return function( \Slim\App $app): \Slim\App {

    // Routes
    $app->get('/', HomeAction::class)->setName('home');

    $app->get('/rdvs/{id}[/]', GetRDVAction::class)->setName('getRDV');

    // Prendre un rendez vous
    $app->post('/rdvs[/]', CreateRDVAction::class)->setName('createRDV');

    // Annuler un rendez-vous
    $app->patch('/rdvs/{id}/cancel[/]', CancelRDVAction::class)->setName('cancelRDV');

    // Obtenir la disponibilité d'un praticien
    $app->get('/praticiens/{id}/disponibility[/]', \app_rdv\application\actions\GetPraticienDisponibilityAction::class)->setName('getPraticienDisponibility');

    // Obtenir le planning d'un praticien
    $app->get('/praticiens/{id}/planing[/]', GetPraticienPlanningAction::class)->setName('getPraticienPlanning');

    // Obtenir les rendez-vous d'un patient
    $app->get('/patients/{patient_id}/rdvs[/]', GetPatientRDVAction::class)->setName('getPatientRDV');

    // Gérer le cycle de vie des rendez-vous (honoré, non honoré, payé)
    $app->patch('/rdvs/{id}/cycle[/]', UpdateRDVCycleAction::class)->setName('updateRDVCycle');

    return $app;
};
