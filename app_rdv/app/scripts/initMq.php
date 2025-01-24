<?php
//init rabit mq connection

require_once __DIR__ . '/../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;

$connection = new AMQPStreamConnection(
    getenv('AMQP_HOST'),
    getenv('AMQP_PORT'),
    getenv('AMQP_USER'),
    getenv('AMQP_PASSWORD')
);
$channel = $connection->channel();

//init fanout exchange
$exchange = getenv('NOTIFY_EXCHANGE');
$channel->exchange_declare($exchange, 'fanout', false, true, false);
$queue_name = "mail";
$channel->queue_declare($queue_name, false, true, false, false);
$channel->queue_bind($queue_name , $exchange);

$msg = new \PhpAmqpLib\Message\AMQPMessage("test from php");

$channel->basic_publish($msg, getenv('NOTIFY_EXCHANGE'));