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
    'log.rdv.name' => 'toubeelib.log',
    'log.rdv.file' => __DIR__ . '/log/toubeelib.error.log',
    'log.rdv.level' => \Monolog\Level::Debug,

    'logger.rdv' => function(ContainerInterface $c) {
        $logger = new \Monolog\Logger($c->get('log.rdv.name'));
        $logger->pushHandler(new \Monolog\Handler\StreamHandler(
                $c->get('log.rdv.file'),
                $c->get('log.rdv.level'))
        );

        return $logger;
    },

    'practicien.pdo' => function(ContainerInterface $c) {
        $config = parse_ini_file(__DIR__ . '/practicien.ini');
        $dsn = "{$config['driver']}:host={$config['host']};dbname={$config['dbname']}";
        $user = $config['username'];
        $password = $config['password'];
        $options = array( \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION );

        return new \PDO($dsn, $user, $password, $options);
    },

    RDVRepositoryInterface::class => function(ContainerInterface $c){
        return new \toubeelib\infrastructure\repositories\ArrayRDVRepository();
    },

    PraticienRepositoryInterface::class => function(ContainerInterface $c){
        return new \toubeelib\infrastructure\repositories\ArrayPraticienRepository();
    },

    ServiceRDVInterface::class => function(ContainerInterface $c){
        return new \toubeelib\core\services\rdv\ServiceRDV($c->get(RDVRepositoryInterface::class),
                                                                $c->get(ServicePraticienInterface::class),
                                                                $c->get('logger.rdv'));
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