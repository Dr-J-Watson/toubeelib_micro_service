<?php
declare(strict_types=1);

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use app_praticiens\application\actions\CreatePraticienAction;
use app_praticiens\application\actions\HomeAction;
use app_praticiens\application\middlewares\Cors;
use app_praticiens\application\actions\GetPraticienPlanningAction;


return function( \Slim\App $app): \Slim\App {

    // Ajout du middleware CORS
    //$app->add(Cors::class);

    // Options route pour CORS
    $app->options('/{routes:.+}', function (Request $rq, Response $rs, array $args) : Response {
        return $rs;
    });

    // Routes

    $app->get('/', HomeAction::class)->setName('home');

    // Créer un praticien
    $app->post('/praticiens[/]', CreatePraticienAction::class)->setName('createPraticien');

    // Obtenir tous les praticiens
    $app->get('/praticiens[/]', \app_praticiens\application\actions\GetPraticiensAction::class)->setName('getPraticiens');

    // Obtenir les détails d'un praticien
    $app->get('/praticiens/{id}[/]', \app_praticiens\application\actions\GetPraticienAction::class)->setName('getPraticien');

    $app->get('/praticiens/{id}/disponibility[/]', \app_praticiens\application\actions\GetPraticienDisponibilityAction::class)->setName('getPraticienDisponibility');

    // Obtenir le planning d'un praticien
    $app->get('/praticiens/{id}/planing[/]', GetPraticienPlanningAction::class)->setName('getPraticienPlanning');

    return $app;
};
