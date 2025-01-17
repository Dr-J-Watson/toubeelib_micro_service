<?php

namespace app_rdv\core\services\rdv;

//use Faker\Core\Uuid;
use Monolog\Logger;
use app_rdv\core\domain\entities\rdv\RDV;
use app_rdv\core\dto\InputRDVDTO;
use app_rdv\core\dto\RDVDTO;
use app_rdv\core\repositoryInterfaces\RDVRepositoryInterface;
use app_rdv\core\services\praticiens\ServicePraticiensAdapterInterface;
use Ramsey\Uuid\Uuid;
use DateTime;
use DateInterval;
use DatePeriod;


class ServiceRDV implements ServiceRDVInterface{
    private RDVRepositoryInterface $rdvRepository;

    private ServicePraticiensAdapterInterface $servicePraticiensAdapter;

    private $logger;
    private $contraintePratitien;

    public function __construct(RDVRepositoryInterface $rdvRepository, Logger $logger, ServicePraticiensAdapterInterface $servicePraticiensAdapter){
        $this->rdvRepository = $rdvRepository;
        $this->logger = $logger;
        $this->contraintePratitien = [
            'heureDebutMatin' => new DateTime('08:00'),
            'heureFinMatin' => new DateTime('12:00'),
            'heureDebutApresMidi' => new DateTime('13:00'),
            'heureFinApresMidi' => new DateTime('17:00'),
            'dureeRdv' => new DateInterval('PT30M'),
        ];
        $this->servicePraticiensAdapter = $servicePraticiensAdapter;
    }

    public function createRDV(InputRDVDTO $p): RDVDTO{
        $rdv = new RDV($p->getPraticienID(),$p->getPatientID(), $p->getType(), $p->getDateHeure());
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
        $rdv->setPraticien($this->servicePraticiensAdapter->getPraticienById($rdv->getPraticienId()));
        return $rdv->toDTO();
    }

    public function getPraticienById(string $idPraticien): string | null
    {
        echo "ServiceRDV getPraticienById".$this->servicePraticiensAdapter->getPraticienById($idPraticien);
        return $this->servicePraticiensAdapter->getPraticienById($idPraticien);
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
        $rdv->update($p->getDateHeure(), $p->getPraticienID(), $p->getPatientID(), $p->getType(), $p->getStatut());
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

        $rdvs =  $this->rdvRepository->getRDVByPatientId($idPatient);
        $rdvsDTO = [];
        foreach($rdvs as $rdv){
            $rdvsDTO[] = $rdv->toDTO();
        }
        return $rdvsDTO;
    }

    public function getPraticienDisponibillity(string $idPraticien, ?string $dateDebut, ?string $dateFin): array
    {
        // Gestion des dates par défaut si null
        $dateDebut = $dateDebut ? new DateTime($dateDebut) : new DateTime();
        $dateFin = $dateFin ? new DateTime($dateFin) : (new DateTime())->add(new DateInterval('P1M'));
    
        // Récupérer les rendez-vous existants du praticien
        $praticienRdvs = $this->rdvRepository->getRDVByPraticienId($idPraticien, $dateDebut->format('Y-m-d'), $dateFin->format('Y-m-d'));
    
        // Créer une liste des créneaux déjà pris
        $creneauxPris = array_map(fn($rdv) => $rdv->dateHeure->format('Y-m-d H:i'), $praticienRdvs);
    
        $disponibilites = [];
        $periode = new DatePeriod($dateDebut, new DateInterval('P1D'), $dateFin);
    
        foreach ($periode as $jour) {
            // Exclure les week-ends (samedi et dimanche)
            if ($jour->format('N') < 6) {
                $disponibilites[$jour->format('Y-m-d')] = array_merge(
                    $this->genererCreneauxDisponibles($jour, $this->contraintePratitien['heureDebutMatin'], $this->contraintePratitien['heureFinMatin'], $creneauxPris),
                    $this->genererCreneauxDisponibles($jour, $this->contraintePratitien['heureDebutApresMidi'], $this->contraintePratitien['heureFinApresMidi'], $creneauxPris)
                );
            }
        }
    
        return $disponibilites;
    }
    
    private function genererCreneauxDisponibles(DateTime $jour, DateTime $heureDebut, DateTime $heureFin, array $creneauxPris): array
    {
        $dureeRdv = $this->contraintePratitien['dureeRdv'];
        $disponibilites = [];
        $heure = clone $heureDebut;
    
        while ($heure < $heureFin) {
            $creneau = $jour->format('Y-m-d') . ' ' . $heure->format('H:i');
            if (!in_array($creneau, $creneauxPris)) {
                $disponibilites[] = $creneau;
            }
            $heure->add($dureeRdv);
        }
    
        return $disponibilites;
    }

    public function updateRDVCycle(string $idRDV, string $cycle): RDVDTO{
        $rdv = $this->rdvRepository->getRDVById($idRDV);
        $rdv->setStatut($cycle);
        $updatedRdv = $this->rdvRepository->save($rdv);
        $this->logger->info('RDV cycle updated: ', ['IdRdv' => $updatedRdv->__get('ID')]);
        return $updatedRdv->toDTO();
    }
    
}