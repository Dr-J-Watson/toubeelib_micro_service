<?php

namespace toubeelib\core\services\rdv;

use toubeelib\core\domain\entities\rdv\RDV;
use toubeelib\core\dto\InputRDVDTO;
use toubeelib\core\dto\RDVDTO;
use toubeelib\core\repositoryInterfaces\RDVRepositoryInterface;

class ServiceRDV implements ServiceRDVInterface{
    private RDVRepositoryInterface $rdvRepository;

    public function __construct(RDVRepositoryInterface $rdvRepository){
        $this->rdvRepository = $rdvRepository;
    }

    public function createRDV(InputRDVDTO $p): RDVDTO{
        $rdv = new RDV($p->dateHeure, $p->practicienID, $p->patientID, $p->type);
        $id = $this->rdvRepository->save($rdv);
        $rdv->setID($id);
        return $rdv->toDTO();
    }

    public function getRDV(string $idRDV): RDVDTO{
        $rdv = $this->rdvRepository->getRDVById($idRDV);
        return $rdv->toDTO();
    }

    public function updateRDV(InputRDVDTO $p): RDVDTO{
        $rdv = new RDV($p->dateHeure, $p->practicienID, $p->patientID, $p->type);
        $rdv->setID($p->ID);
        $this->rdvRepository->save($rdv);
        return $rdv->toDTO();
    }

    public function cancelRDV(string $idRDV): void{
        $rdv = $this->rdvRepository->getRDVById($idRDV);
        $rdv->setStatut('CANCEL');
        $this->rdvRepository->save($rdv);
    }

    public function getRDVByPraticien(string $idPraticien): array{
        return $this->rdvRepository->getRDVByPraticienId($idPraticien);
    }

    public function getRDVByPatient(string $idPatient): array{
        return $this->rdvRepository->getRDVByPatientId($idPatient);
    }
}