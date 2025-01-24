<?php
namespace app_rdv\application\interfaces\messages;

use app_rdv\core\dto\RDVDTO;

interface RdvMessageSenderInterface
{
    public function sendMessage(RDVDTO $rdv, string $event): void;
}