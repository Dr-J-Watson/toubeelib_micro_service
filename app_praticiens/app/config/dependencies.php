<?php

use Psr\Container\ContainerInterface;
use app_praticiens\application\actions\GetPraticienAction;
use app_praticiens\application\actions\GetPraticiensAction;
use app_praticiens\application\actions\CreatePraticienAction;


return [

    'praticien.pdo' => function(ContainerInterface $c) {
        $pdo = new PDO('pgsql:host=toubeelib.db;dbname=praticien', 'root', 'root');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    },

    'client' => function() {
        return new GuzzleHttp\Client();
    },

    'Repository' => function(ContainerInterface $c){
        return new \app_praticiens\infrastructure\repositories\PDOPraticienRepository($c->get('praticien.pdo'));
    },

    'Service' => function(ContainerInterface $c){
        return new \app_praticiens\core\services\praticien\ServicePraticien($c->get('Repository'));
    },

    GetPraticienAction::class => function(ContainerInterface $c){
        return new \app_praticiens\application\actions\GetPraticienAction($c->get('Service'));
    },

    GetPraticiensAction::class=> function(ContainerInterface $c){
        return new \app_praticiens\application\actions\GetPraticiensAction($c->get('Service'));
    },

    CreatePraticienAction::class => function(ContainerInterface $c){
        return new \app_praticiens\application\actions\CreatePraticienAction($c->get('Service'));
    }
];