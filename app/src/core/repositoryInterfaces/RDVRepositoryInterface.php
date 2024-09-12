<?php

namespace toubeelib\core\repositoryInterfaces;

use toubeelib\core\domain\entities\praticien\RDV;

interface RDVRepositoryInterface
{
    public function save(RDV $rdv): string;
    public function getRDVById(string $id): RDV;
    public function getRDVByPraticienId(string $id): array;
    public function getRDVByPatientId(string $id): array;
}