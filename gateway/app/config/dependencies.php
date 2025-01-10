<?php

use gateway\application\actions\GenericPraticienAction;
use Psr\Container\ContainerInterface;

return [
//    'log.rdv.name' => 'toubeelib.log',
//    'log.rdv.file' => __DIR__ . '/logs/toubeelib.rdv.log',
//    'log.rdv.level' => \Monolog\Level::Debug,
//
//    'logger.rdv' => function(ContainerInterface $c) {
//        $logger = new \Monolog\Logger($c->get('log.rdv.name'));
//        $logger->pushHandler(new \Monolog\Handler\StreamHandler(
//                $c->get('log.rdv.file'),
//                $c->get('log.rdv.level'))
//        );
//
//        return $logger;
//    },

    'praticien_client' => function(ContainerInterface $c){
        return new GuzzleHttp\Client([
            'base_uri' => 'http://api.toubeelib:80',
            'timeout' => 2.0,
        ]);
    },

    GenericPraticienAction::class => function(ContainerInterface $c) {
        return new GenericPraticienAction($c->get('praticien_client'));
    },

];