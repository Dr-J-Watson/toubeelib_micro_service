<?php

namespace toubeelib\core\services\rdv;

//use Faker\Core\Uuid;
use Monolog\Logger;
use toubeelib\core\domain\entities\rdv\RDV;
use toubeelib\core\dto\InputRDVDTO;
use toubeelib\core\dto\RDVDTO;
use toubeelib\core\repositoryInterfaces\RDVRepositoryInterface;
use Psr\Log\LoggerInterface;
use Ramsey\Uuid\Uuid;
class ServiceRDV implements ServiceRDVInterface{
    private RDVRepositoryInterface $rdvRepository;
    private $logger;

    public function __construct(RDVRepositoryInterface $rdvRepository, Logger $logger){
        $this->rdvRepository = $rdvRepository;
        $this->logger = $logger;
    }

    public function createRDV(InputRDVDTO $p): RDVDTO{
        $rdv = new RDV($p->getPracticienID(),$p->getPatientID(), $p->getType(), $p->getDateHeure());
        $rdv->setID(Uuid::uuid4());
        $this->rdvRepository->save($rdv);
        $this->logger->info('RDV created: ',['rdv' => $rdv]);
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
        $this->logger->info('RDV cancelled: ', ['IdRdv' => $updatedRdv->__get('ID')]);
        return $updatedRdv->toDTO();
    }

    public function updateRDV(InputRDVDTO $p): RDVDTO{
        $rdv = $this->rdvRepository->getRDVById($p->id);
        $rdv->update($p->getDateHeure(), $p->getPracticienID(), $p->getPatientID(), $p->getType(), $p->getStatut());
        $this->rdvRepository->save($rdv);
        $this->logger->info('RDV updated: ',['rdv' => $rdv]);
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