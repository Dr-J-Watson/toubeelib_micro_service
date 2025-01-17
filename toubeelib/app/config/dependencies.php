<?php

use Psr\Container\ContainerInterface;
use toubeelib\core\services\rdv\ServiceRDVInterface;
use toubeelib\core\repositoryInterfaces\RDVRepositoryInterface;
use toubeelib\core\repositoryInterfaces\PraticienRepositoryInterface;
use toubeelib\core\services\praticien\ServicePraticienInterface;
use toubeelib\application\actions\GetRDVAction;
use toubeelib\application\actions\GetPatientRDVAction;
use toubeelib\application\actions\CreateRDVAction;
use toubeelib\application\actions\CancelRDVAction;
use toubeelib\application\actions\GetPraticienDisponibilityAction;
use toubeelib\application\actions\GetPraticienAction;
use toubeelib\application\actions\GetPraticiensAction;
use toubeelib\application\actions\GetPraticienPlanningAction;
use toubeelib\application\actions\CreatePraticienAction;


return [
    'log.rdv.name' => 'toubeelib.log',
    'log.rdv.file' => __DIR__ . '/logs/toubeelib.rdv.log',
    'log.rdv.level' => \Monolog\Level::Debug,

    'logger.rdv' => function(ContainerInterface $c) {
        $logger = new \Monolog\Logger($c->get('log.rdv.name'));
        $logger->pushHandler(new \Monolog\Handler\StreamHandler(
                $c->get('log.rdv.file'),
                $c->get('log.rdv.level'))
        );

        return $logger;
    },

    'rdv.pdo' => function(ContainerInterface $c) {
        $pdo = new PDO('pgsql:host=db.toubeelib;dbname=rdv', 'root', 'root');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    },

    'praticien.pdo' => function(ContainerInterface $c) {
        $pdo = new PDO('pgsql:host=db.toubeelib;dbname=praticien', 'root', 'root');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    },

    RDVRepositoryInterface::class => function(ContainerInterface $c){
        return new \toubeelib\infrastructure\repositories\PDORdvRepository($c->get('rdv.pdo'));
    },

    PraticienRepositoryInterface::class => function(ContainerInterface $c){
        return new \toubeelib\infrastructure\repositories\PDOPraticienRepository($c->get('praticien.pdo'));
    },

    ServiceRDVInterface::class => function(ContainerInterface $c){
        return new \toubeelib\core\services\rdv\ServiceRDV($c->get(RDVRepositoryInterface::class),
                                                                $c->get('logger.rdv'));
    },

    ServicePraticienInterface::class => function(ContainerInterface $c){
        return new \toubeelib\core\services\praticien\ServicePraticien($c->get(PraticienRepositoryInterface::class));
    },

    GetRDVAction::class => function(ContainerInterface $c){
        return new \toubeelib\application\actions\GetRDVAction($c->get(ServiceRDVInterface::class));
    },

    GetPatientRDVAction::class => function(ContainerInterface $c){
        return new \toubeelib\application\actions\GetPatientRDVAction($c->get(ServiceRDVInterface::class));
    },

    CreateRDVAction::class => function(ContainerInterface $c){
        return new \toubeelib\application\actions\CreateRDVAction($c->get(ServiceRDVInterface::class));
    },

    CancelRDVAction::class => function(ContainerInterface $c){
        return new \toubeelib\application\actions\CancelRDVAction($c->get(ServiceRDVInterface::class));
    },

    GetPraticienAction::class => function(ContainerInterface $c){
        return new \toubeelib\application\actions\GetPraticienAction($c->get(ServicePraticienInterface::class));
    },

    GetPraticiensAction::class=> function(ContainerInterface $c){
        return new \toubeelib\application\actions\GetPraticiensAction($c->get(ServicePraticienInterface::class));
    },

    GetPraticienDisponibilityAction::class => function (ContainerInterface $c) {
        return new \toubeelib\application\actions\GetPraticienDisponibilityAction($c->get(ServiceRDVInterface::class));
    },

    GetPraticienPlanningAction::class => function(ContainerInterface $c){
        return new \toubeelib\application\actions\GetPraticienPlanningAction($c->get(ServiceRDVInterface::class));
    },

    CreatePraticienAction::class => function(ContainerInterface $c){
        return new \toubeelib\application\actions\CreatePraticienAction($c->get(ServicePraticienInterface::class));
    }
];