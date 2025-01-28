<?php

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;
use Dotenv\Dotenv;

require_once './vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$queue = 'mail';
$mailcatcherDsn = $_ENV['MAILER_DSN'];
$host = $_ENV['BROKER_HOST'];
$port = $_ENV['BROKER_PORT'];
$user = $_ENV['BROKER_USER'];
$password = $_ENV['BROKER_PASSWORD'];

try {
    $connection = new AMQPStreamConnection($host, $port, $user, $password);
    $channel = $connection->channel();

    $mailer = createMailer($mailcatcherDsn);

    $callback = function(AMQPMessage $msg) use ($mailer){
        $msg_body = $msg->body;
        print "[x] message reçu : " . $msg_body . "\n";
        $msg->getChannel()->basic_ack($msg->getDeliveryTag());
        sendEmail($mailer, $msg_body);
    };

    $channel->basic_consume($queue, '', false, false, false, false, $callback);

    while ($channel->is_consuming()) {
        $channel->wait();
    }

} catch (Exception $e) {
    print $e->getMessage();
} finally {
    if (isset($channel) && $channel->is_consuming()) {
        $channel->close();
    }
    if (isset($connection)) {
        $connection->close();
    }
}

function createMailer(string $dsn): Mailer
{
    $transport = Transport::fromDsn($dsn);
    return new Mailer($transport);
}

function sendEmail(MailerInterface $mailer, $msg): void
{
    $email = new Email();
    $email->from('sender@example.com');
    $email->to('recipient@example.com');
    $email->subject('Sujet de l\'email');
    $email->text('Contenu texte simple');
    $email->html($msg);

    try {
        $mailer->send($email);
    } catch (TransportExceptionInterface $e) {
        print $e->getMessage();
    }
}
