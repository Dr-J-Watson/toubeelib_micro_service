<?php

namespace toubeelib\core\services\rdv;
use toubeelib\core\domain\entities\rdv\RDV;
use toubeelib\core\dto\InputRDVDTO;
use toubeelib\core\dto\RDVDTO;
use toubeelib\core\repositoryInterfaces\RDVRepositoryInterface;

class ServiceRDV implements ServiceRDVInterface
{
    private RDVRepositoryInterface $rdvRepository;

    public function __construct(RDVRepositoryInterface $rdvRepository)
    {
        $this->rdvRepository = $rdvRepository;
    }

    public function createRDV(InputRDVDTO $inputRDVDTO): RDVDTO
    {
        // TODO : valider les données et créer l'entité-

        return new RDVDTO($RDV);
    }

    /**
     * @return RDVDTO[]
     */
    public function getRDV(string $idRDV): RDVDTO
    {
        return $this->rdvRepository->getRDVById($idRDV);
    }

    public function updateRDV(InputRDVDTO $p): RDVDTO
    {
        $rdv = $this->rdvRepository->save($p);
        return new RDVDTO($rdv);
    }

    public function cancelRDV(string $idRDV): void
    {
        $this->rdvRepository->cancelRDV($idRDV);
    }

    public function getRDVByPraticien(string $idPraticien): RDVDTO
    {
        return $this->rdvRepository->getRDVByPraticien($idPraticien);
    }

    public function getRDVByPatient(string $idPatient): RDVDTO
    {
        return $this->rdvRepository->getRDVByPatient($idPatient);
    }
}