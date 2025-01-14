<?php

use Psr\Container\ContainerInterface;
use app_auth\core\services\rdv\ServiceRDVInterface;
use app_auth\core\repositoryInterfaces\RDVRepositoryInterface;
use app_auth\core\repositoryInterfaces\PraticienRepositoryInterface;
use app_auth\core\services\praticien\ServicePraticienInterface;
use app_auth\application\actions\GetRDVAction;
use app_auth\application\actions\GetPatientRDVAction;
use app_auth\application\actions\CreateRDVAction;
use app_auth\application\actions\CancelRDVAction;
use app_auth\application\actions\GetPraticienDisponibilityAction;
use app_auth\application\actions\GetPraticienAction;
use app_auth\application\actions\GetPraticiensAction;
use app_auth\application\actions\GetPraticienPlanningAction;
use app_auth\application\actions\CreatePraticienAction;


return [

    'rdv.pdo' => function(ContainerInterface $c) {
        $pdo = new PDO('pgsql:host=db.auth;dbname=rdv', 'root', 'root');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    },

    'praticien.pdo' => function(ContainerInterface $c) {
        $pdo = new PDO('pgsql:host=db.auth;dbname=praticien', 'root', 'root');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    },
];