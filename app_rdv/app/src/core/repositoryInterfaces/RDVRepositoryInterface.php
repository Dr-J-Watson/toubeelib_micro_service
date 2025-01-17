<?php

namespace app_rdv\core\repositoryInterfaces;

// use toubeelib\core\domain\entities\praticien\RDV;
use app_rdv\core\domain\entities\rdv\RDV;
use app_rdv\core\dto\RDVDTO;

interface RDVRepositoryInterface
{
    public function save(RDV $rdv): RDV;
    public function getRDVById(string $id): RDV;
    
    /**
     * @return RDVDTO[]
     */
    public function getRDVByPraticienId(string $id, ?string $dateDebut, ?string $dateFin ): array;
    
    public function getRDVByPatientId(string $id): array;
}