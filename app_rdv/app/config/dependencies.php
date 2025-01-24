<?php

use Psr\Container\ContainerInterface;
use app_rdv\core\services\rdv\ServiceRDVInterface;
use app_rdv\core\services\praticiens\ServicePraticiensAdapterInterface;
use app_rdv\infrastructure\adapters\HttpPraticiensAdapter;
use app_rdv\core\repositoryInterfaces\RDVRepositoryInterface;
use app_rdv\application\actions\GetRDVAction;
use app_rdv\application\actions\GetPatientRDVAction;
use app_rdv\application\actions\CreateRDVAction;
use app_rdv\application\actions\CancelRDVAction;
use app_rdv\application\actions\GetPraticienDisponibilityAction;
use app_rdv\application\actions\GetPraticienPlanningAction;
use app_rdv\application\actions\UpdateRDVCycleAction;
use app_rdv\application\interfaces\messages\RdvMessageSenderInterface;



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

    'praticien_client' => function(ContainerInterface $c){
        return new GuzzleHttp\Client([
            'base_uri' => 'http://api.praticiens:80',
            'timeout' => 2.0,
            'headers' => [
                'Origin' => 'http://api.rdv:80'
            ]
        ]);
    },

    'rdv_message_broker' => function(ContainerInterface $c){
        return new \PhpAmqpLib\Connection\AMQPStreamConnection(
            getenv('AMQP_HOST'),
            getenv('AMQP_PORT'),
            getenv('AMQP_USER'),
            getenv('AMQP_PASSWORD')
        );
    },

    RdvMessageSenderInterface::class => function(ContainerInterface $c){
        return new \app_rdv\infrastructure\adapters\RabbitMQRdvMessageSender($c->get('rdv_message_broker'), getenv('NOTIFY_EXCHANGE'));
    },

    RDVRepositoryInterface::class => function(ContainerInterface $c){
        return new \app_rdv\infrastructure\repositories\PDORdvRepository($c->get('rdv.pdo'));
    },

    ServicePraticiensAdapterInterface::class => function(ContainerInterface $c){
        return new HttpPraticiensAdapter($c->get('praticien_client'));
    },

    ServiceRDVInterface::class => function(ContainerInterface $c){
        return new \app_rdv\core\services\rdv\ServiceRDV($c->get(RDVRepositoryInterface::class),
                                                                $c->get('logger.rdv'), $c->get(ServicePraticiensAdapterInterface::class));
    },

    GetRDVAction::class => function(ContainerInterface $c){
        return new \app_rdv\application\actions\GetRDVAction($c->get(ServiceRDVInterface::class));
    },

    GetPatientRDVAction::class => function(ContainerInterface $c){
        return new \app_rdv\application\actions\GetPatientRDVAction($c->get(ServiceRDVInterface::class));
    },

    CreateRDVAction::class => function(ContainerInterface $c){
        return new \app_rdv\application\actions\CreateRDVAction($c->get(ServiceRDVInterface::class), $c->get(RdvMessageSenderInterface::class));
    },

    CancelRDVAction::class => function(ContainerInterface $c){
        return new \app_rdv\application\actions\CancelRDVAction($c->get(ServiceRDVInterface::class));
    },

    GetPraticienDisponibilityAction::class => function (ContainerInterface $c) {
        return new \app_rdv\application\actions\GetPraticienDisponibilityAction($c->get(ServiceRDVInterface::class));
    },

    GetPraticienPlanningAction::class => function(ContainerInterface $c){
        return new \app_rdv\application\actions\GetPraticienPlanningAction($c->get(ServiceRDVInterface::class));
    },

    UpdateRDVCycleAction::class => function(ContainerInterface $c){
        return new \app_rdv\application\actions\UpdateRDVCycleAction($c->get(ServiceRDVInterface::class));
    }
];