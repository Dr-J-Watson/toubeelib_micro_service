<?php

namespace app_praticiens\core\services\praticien;

use app_praticiens\core\dto\InputPraticienDTO;
use app_praticiens\core\dto\PraticienDTO;
use app_praticiens\core\dto\SpecialiteDTO;

interface ServicePraticienInterface
{

    public function createPraticien(InputPraticienDTO $p): PraticienDTO;
    public function getPraticienById(string $id): PraticienDTO;
    public function getSpecialiteById(string $id): SpecialiteDTO;

    /**
     * @return PraticienDTO[]
     */
    public function getPraticiens(string $nom, string $ville, string $specialite, int $page): array;

    public function getPraticien(string $id): PraticienDTO;

}