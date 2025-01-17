<?php

namespace app_rdv\core\repositoryInterfaces;

use app_rdv\core\domain\entities\praticien\Praticien;
use app_rdv\core\domain\entities\praticien\Specialite;

interface PraticienRepositoryInterface
{

    public function getSpecialiteById(string $id): Specialite;
    public function save(Praticien $praticien): Praticien;
    public function getPraticienById(string $id): Praticien;
    public function getPraticiens(string $nom, string $ville, string $specialite, int $page): array;

}