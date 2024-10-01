<?php

use Psr\Container\ContainerInterface;
use toubeelib\core\services\rdv\ServiceRDVInterface;
use toubeelib\core\repositoryInterfaces\RDVRepositoryInterface;
use toubeelib\core\repositoryInterfaces\PraticienRepositoryInterface;
use toubeelib\core\services\praticien\ServicePraticienInterface;
use toubeelib\application\actions\GetRDVAction;
use toubeelib\application\actions\CancelRDVAction;
use toubeelib\application\actions\GetPraticienPlanningAction;
use toubeelib\application\actions\CreatePraticienAction;


return [
    RDVRepositoryInterface::class => function(ContainerInterface $c){
        return new \toubeelib\infrastructure\repositories\ArrayRDVRepository();
    },

    PraticienRepositoryInterface::class => function(ContainerInterface $c){
        return new \toubeelib\infrastructure\repositories\ArrayPraticienRepository();
    },

    ServiceRDVInterface::class => function(ContainerInterface $c){
        return new \toubeelib\core\services\rdv\ServiceRDV($c->get(RDVRepositoryInterface::class));
    },

    ServicePraticienInterface::class => function(ContainerInterface $c){
        return new \toubeelib\core\services\praticien\ServicePraticien($c->get(PraticienRepositoryInterface::class));
    },

    GetRDVAction::class => function(ContainerInterface $c){
        return new \toubeelib\application\actions\GetRDVAction($c->get(ServiceRDVInterface::class));
    },

    CancelRDVAction::class => function(ContainerInterface $c){
        return new \toubeelib\application\actions\CancelRDVAction($c->get(ServiceRDVInterface::class));
    },

    GetPraticienPlanningAction::class => function(ContainerInterface $c){
        return new \toubeelib\application\actions\GetPraticienPlanningAction($c->get(ServiceRDVInterface::class));
    },

    CreatePraticienAction::class => function(ContainerInterface $c){
        return new \toubeelib\application\actions\CreatePraticienAction($c->get(ServicePraticienInterface::class));
    }
];