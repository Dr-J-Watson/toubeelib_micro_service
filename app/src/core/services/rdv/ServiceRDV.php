<?php

namespace toubeelib\core\services\rdv;

use Faker\Core\Uuid;
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
        $rdv = new RDV($p->getPracticienID(),$p->getPatientID(), $p->getType(), $p->getDateHeure());
        $id = $this->rdvRepository->save($rdv);
        $rdv->setID(uniqid());
        return $rdv->toDTO();
    }

    // public function getRDV(string $idRDV): RDVDTO{
    //     $rdv = $this->rdvRepository->getRDVById($idRDV);
    //     return $rdv->toDTO();
    // }

    public function getRDVById(string $idRDV): RDVDTO{
        $rdv = $this->rdvRepository->getRDVById($idRDV);
        return $rdv->toDTO();
    }

    public function cancelRDV(string $idRDV): RDVDTO{
        $rdv = $this->rdvRepository->getRDVById($idRDV);
        $rdv->setStatut('CANCEL');
        $updatedRdv = $this->rdvRepository->save($rdv);
        return $updatedRdv->toDTO();
    }

    public function updateRDV(InputRDVDTO $p): RDVDTO{
        $rdv = $this->rdvRepository->getRDVById($p->id);
        $rdv->update($p->getDateHeure(), $p->getPracticienID(), $p->getPatientID(), $p->getType(), $p->getStatut());
        $this->rdvRepository->save($rdv);
        return $rdv->toDTO();
    }

    /**
     * @return RDVDTO[]
     */
    public function getRDVByPraticien(string $idPraticien, ?string $dateDebut, ?string $dateFin): array{
        return $this->rdvRepository->getRDVByPraticienId($idPraticien, $dateDebut, $dateFin);
    }

    public function getRDVByPatient(string $idPatient): array{
        return $this->rdvRepository->getRDVByPatientId($idPatient);
    }
}