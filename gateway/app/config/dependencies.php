<?php

use gateway\application\actions\GenericAuthAction;
use gateway\application\actions\GenericPraticienAction;
use gateway\application\actions\GenericRdvAction;
use gateway\application\middlewares\AuthMiddleware;
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
            'base_uri' => 'http://api.praticiens:80',
            'timeout' => 2.0,
        ]);
    },


    'auth_client' => function(ContainerInterface $c){
        return new GuzzleHttp\Client([
            'base_uri' => 'http://api.praticiens:80',
            'timeout' => 2.0,
        ]);
    },

    'rdv_client' => function(ContainerInterface $c){
        return new GuzzleHttp\Client([
            'base_uri' => 'http://api.rdv:80',
            'timeout' => 2.0,
        ]);
    },

    AuthMiddleware::class => function(ContainerInterface $c) {
        return new AuthMiddleware($c->get('auth_client'));
    },

    GenericPraticienAction::class => function(ContainerInterface $c) {
        return new GenericPraticienAction($c->get('praticien_client'));
    },

    GenericAuthAction::class => function(ContainerInterface $c) {
        return new GenericAuthAction($c->get('auth_client'));
    },

    GenericRdvAction::class => function(ContainerInterface $c) {
        return new GenericRdvAction($c->get('rdv_client'));
    },

];