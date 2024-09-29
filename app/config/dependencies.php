<?php

use Psr\Container\ContainerInterface;
use toubeelib\core\repositoryInterfaces\RDVRepositoryInterface;
use toubeelib\core\services\rdv\ServiceRDVInterface;
use toubeelib\application\actions\GetRDVAction;
use toubeelib\application\actions\CancelRDVAction;
use toubeelib\application\actions\GetPraticienDisponibilityAction;

return [
    RDVRepositoryInterface::class => function(ContainerInterface $c){
        return new \toubeelib\infrastructure\repositories\ArrayRDVRepository();
    },

    ServiceRDVInterface::class => function(ContainerInterface $c){
        return new \toubeelib\core\services\rdv\ServiceRDV($c->get(RDVRepositoryInterface::class));
    },

    GetRDVAction::class => function(ContainerInterface $c){
        return new \toubeelib\application\actions\GetRDVAction($c->get(ServiceRDVInterface::class));
    },

    CancelRDVAction::class => function(ContainerInterface $c){
        return new \toubeelib\application\actions\CancelRDVAction($c->get(ServiceRDVInterface::class));
    },

    GetPraticienDisponibilityAction::class => function(ContainerInterface $c){
        return new \toubeelib\application\actions\GetPraticienDisponibilityAction($c->get(ServiceRDVInterface::class));
    }
];