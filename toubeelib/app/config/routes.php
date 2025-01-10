<?php
declare(strict_types=1);

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
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
use toubeelib\application\middlewares\Cors;

return function( \Slim\App $app): \Slim\App {

    // // Ajout du middleware CORS
    // $app->add(toubeelib\application\middlewares\Cors::class);

    // // Options route pour CORS
    // $app->options('/{routes:.+}', function (Request $rq, Response $rs, array $args) : Response {
    //     return $rs;
    // });

    // Routes

    $app->get('/', HomeAction::class)->setName('home');

    $app->get('/rdvs/{id}[/]', GetRDVAction::class)->setName('getRDV');
        // ->add(new JWTAuthMiddleware());

    // Prendre un rendez vous
    $app->post('/rdvs[/]', CreateRDVAction::class)->setName('createRDV');

    // Annuler un rendez-vous
    $app->patch('/rdvs/{id}/cancel[/]', CancelRDVAction::class)->setName('cancelRDV');

    // Créer un praticien
    $app->post('/praticiens[/]', CreatePraticienAction::class)->setName('createPraticien');

    // Obtenir tous les praticiens
    $app->get('/praticiens[/]', \toubeelib\application\actions\GetPraticiensAction::class)->setName('getPraticiens');

    // Obtenir les détails d'un praticien
    $app->get('/praticiens/{id}[/]', \toubeelib\application\actions\GetPraticienAction::class)->setName('getPraticien');

    // Obtenir la disponibilité d'un praticien
    $app->get('/praticiens/{id}/disponibility[/]', \toubeelib\application\actions\GetPraticienDisponibilityAction::class)->setName('getPraticienDisponibility');

    // Obtenir le planning d'un praticien
    $app->get('/praticiens/{id}/planing[/]', GetPraticienPlanningAction::class)->setName('getPraticienPlanning');
        // ->add(new JWTAuthMiddleware());

    // Obtenir les rendez-vous d'un patient
    $app->get('/patients/{patient_id}/rdvs[/]', GetPatientRDVAction::class)->setName('getPatientRDV');
        // ->add(new JWTAuthMiddleware());

    // Gérer le cycle de vie des rendez-vous (honoré, non honoré, payé)
    $app->patch('/rdvs/{id}/cycle[/]', UpdateRDVCycleAction::class)->setName('updateRDVCycle');

    // Authentification
    $app->post('/users/signin[/]', AuthAction::class)->setName('signin');

    // Rafraîchir le token JWT
    $app->post('/refresh', AuthAction::class)->setName('refresh');
        // ->add(new JWTAuthMiddleware());

    return $app;
};
