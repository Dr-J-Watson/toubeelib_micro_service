<?php

namespace app_rdv\infrastructure\adapters;


use app_rdv\core\dto\RDVDTO;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use app_rdv\application\interfaces\messages\RdvMessageSenderInterface;

class RabbitMQRdvMessageSender implements RdvMessageSenderInterface
{

    private $connection;
    private $channel;
    private $exchange;

    public function __construct(AMQPStreamConnection $connection, $exchange)
    {
        $this->connection = $connection;
        $this->channel = $connection->channel();
        $this->exchange = $exchange;
    }

    public function sendMessage(RDVDTO $rdv, string $event): void
    {
        $msg = new AMQPMessage(json_encode(['event' => $event, 'rdv' => $rdv->jsonSerialize()]));
        $this->channel->basic_publish($msg, $this->exchange);
    }

    public function __destruct()
    {
        $this->channel->close();
        $this->connection->close();
    }
}