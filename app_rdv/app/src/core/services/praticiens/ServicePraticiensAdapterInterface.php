<?php

namespace app_rdv\core\services\praticiens;


use app_rdv\core\dto\PraticienDTO;

interface ServicePraticiensAdapterInterface
{
    public function getPraticienById(string $praticienId): PraticienDTO | string;

}