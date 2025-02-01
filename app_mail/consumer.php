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
        $msg_body = $msg->getBody();
        echo ">>>>>>>>>>[x] message reçu : " . $msg_body . "\n";
        $msg->getChannel()->basic_ack($msg->getDeliveryTag());

        $msg_data = json_decode($msg_body);
        if (json_last_error() !== JSON_ERROR_NONE) {
            echo "Erreur de décodage JSON : " . json_last_error_msg();
            return;
        }

        sendEmail($mailer, $msg_data);
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

function sendEmail(MailerInterface $mailer, $msg_data): void
{
    // Convert the praticien object to an associative array
    $rdv = json_decode(json_encode($msg_data->rdv));

    if (!isset($msg_data->event) || !isset($rdv) || !isset($rdv->dateHeure) || !isset($rdv->praticien) || !isset($rdv->praticien->nom) || !isset($rdv->praticien->prenom)) {
        echo "Erreur : Propriétés manquantes dans les données du message.";
        return;
    }

    $email = new Email();
    $email->from('sender@example.com');
    $email->to('recipient@example.com');
    $email->subject($msg_data->event . ' rendez-vous');
    $email->text('Rendez-vous du '.$rdv->dateHeure.' avec '.$rdv->praticien->nom . ' ' . $rdv->praticien->prenom);
    try {
        $mailer->send($email);
    } catch (TransportExceptionInterface $e) {
        echo "Erreur lors de l'envoi du mail : " . $e->getMessage();
    } catch (Exception $e) {
        echo "Erreur inconnue lors de l'envoi du mail : " . $e->getMessage();
    }
}
