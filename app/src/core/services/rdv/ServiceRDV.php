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
use DateTime;
use DateInterval;
use DatePeriod;


class ServiceRDV implements ServiceRDVInterface{
    private RDVRepositoryInterface $rdvRepository;
    private $logger;
    private $contraintePratitien;

    public function __construct(RDVRepositoryInterface $rdvRepository, Logger $logger){
        $this->rdvRepository = $rdvRepository;
        $this->logger = $logger;
        $this->contraintePratitien = [
            'heureDebutMatin' => new DateTime('08:00'),
            'heureFinMatin' => new DateTime('12:00'),
            'heureDebutApresMidi' => new DateTime('13:00'),
            'heureFinApresMidi' => new DateTime('17:00'),
            'dureeRdv' => new DateInterval('PT30M'),
        ];
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

        $rdvs =  $this->rdvRepository->getRDVByPatientId($idPatient);
        $rdvsDTO = [];
        foreach($rdvs as $rdv){
            $rdvsDTO[] = $rdv->toDTO();
        }
        return $rdvsDTO;
    }

    public function getPraticienDisponibillity(string $idPraticien, string $dateDebut, string $dateFin): array
    {
        $praticienRdvs = $this->rdvRepository->getRDVByPraticienId($idPraticien, $dateDebut, $dateFin);
        $heureDebutMatin = $this->contraintePratitien['heureDebutMatin'];
        $heureFinMatin = $this->contraintePratitien['heureFinMatin'];
        $heureDebutApresMidi = $this->contraintePratitien['heureDebutApresMidi'];
        $heureFinApresMidi = $this->contraintePratitien['heureFinApresMidi'];
        $dureeRdv = $this->contraintePratitien['dureeRdv'];

        $creneauxPris = [];
        foreach ($praticienRdvs as $rdv) {
            $creneauxPris[] = $rdv->dateHeure->format('Y-m-d H:i');
        }

        $disponibilites = [];
        $periode = new DatePeriod(new DateTime($dateDebut), new DateInterval('P1D'), new DateTime($dateFin));
        foreach ($periode as $jour) {
            if ($jour->format('N') < 6) { // Exclure samedi et dimanche
                $date = $jour->format('Y-m-d');
                $disponibilites[$date] = [];
                $heure = clone $heureDebutMatin;
                while ($heure < $heureFinMatin) {
                    $creneau = $date . ' ' . $heure->format('H:i');
                    if (!in_array($creneau, $creneauxPris)) {
                        $disponibilites[$date][] = $creneau;
                    }
                    $heure->add($dureeRdv);
                }
                $heure = clone $heureDebutApresMidi;
                while ($heure < $heureFinApresMidi) {
                    $creneau = $date . ' ' . $heure->format('H:i');
                    if (!in_array($creneau, $creneauxPris)) {
                        $disponibilites[$date][] = $creneau;
                    }
                    $heure->add($dureeRdv);
                }
            }
        }
        return $disponibilites;
    }
}