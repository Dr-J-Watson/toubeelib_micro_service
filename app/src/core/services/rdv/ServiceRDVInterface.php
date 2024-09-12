<?php

namespace toubeelib\core\services\rdv;

use toubeelib\core\dto\InputRDVDTO;
use toubeelib\core\dto\RDVDTO;

interface ServiceRDVInterface
{
    
    public function createRDV(InputRDVDTO $p): RDVDTO;

    /**
     * @return RDVDTO[]
     */
    public function getRDV(string $idRDV): array;

    public function updateRDV(InputRDVDTO $p): RDVDTO;

    public function cancelRDV(string $idRDV): void;

    public function getRDVByPraticien(string $idPraticien): RDVDTO;

    public function getRDVByPatient(string $idPatient): RDVDTO;

    // TODO add a method getRDVByPatient

    // public function createPraticien(InputPraticienDTO $p): PraticienDTO;
    // public function getPraticienById(string $id): PraticienDTO;
    // public function getSpecialiteById(string $id): SpecialiteDTO;


}