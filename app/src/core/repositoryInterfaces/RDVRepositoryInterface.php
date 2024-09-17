<?php

namespace toubeelib\core\repositoryInterfaces;

// use toubeelib\core\domain\entities\praticien\RDV;
use toubeelib\core\domain\entities\rdv\RDV;
use toubeelib\core\dto\RDVDTO;

interface RDVRepositoryInterface
{
    public function save(RDV $rdv): RDV;
    public function getRDVById(string $id): RDV;
    public function getRDVByPraticienId(string $id): array;
    public function getRDVByPatientId(string $id): array;
}