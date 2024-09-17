<?php

use Psr\Container\ContainerInterface;
use toubeelib\core\repositoryInterfaces\RDVRepositoryInterface;
use toubeelib\core\services\rdv\ServiceRDVInterface;
use toubeelib\application\actions\GetRDVAction;


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
];