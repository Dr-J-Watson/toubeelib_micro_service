<?php

namespace toubeelib\infrastructure\repositories;

use Ramsey\Uuid\Uuid;
use toubeelib\core\domain\entities\rdv\RDV;
use toubeelib\core\dto\RDVDTO;
use toubeelib\core\repositoryInterfaces\RDVRepositoryInterface;
use toubeelib\core\repositoryInterfaces\RepositoryEntityNotFoundException;

class ArrayRdvRepository implements RDVRepositoryInterface
{
    private array $rdvs = [];

    public function __construct() {
            $r1 = new RDV('p1', 'pa1', 'A', \DateTimeImmutable::createFromFormat('Y-m-d H:i','2024-09-02 09:00') );
            $r1->setID('r1');
            $r2 = new RDV('p1', 'pa1', 'A', \DateTimeImmutable::createFromFormat('Y-m-d H:i','2024-09-02 10:00'));
            $r2->setID('r2');
            $r3 = new RDV('p2', 'pa1', 'A', \DateTimeImmutable::createFromFormat('Y-m-d H:i','2024-09-02 09:30'));
            $r3->setID('r3');

        $this->rdvs  = ['r1'=> $r1, 'r2'=>$r2, 'r3'=> $r3 ];
    }

    public function save(RDV $rdv): RDV
    {
        $this->rdvs[$rdv->getID()] = $rdv;
        return $rdv;
    }

    public function getRDVById(string $id): RDV
    {
        if (!isset($this->rdvs[$id])) {
            throw new RepositoryEntityNotFoundException("RDV with id $id not found");
        }
        return $this->rdvs[$id];
    }

    /**
     * @return RDVDTO[]
     */
    public function getRDVByPraticienId(string $pid, $dateDebut, $dateFin): array
    {
        $rdvs = [];
        foreach ($this->rdvs as $rdv) {
            if ($rdv->getPraticienId() === $pid) {
                $rdvs[] = $rdv->toDTO();
            }
        }
        return $rdvs;

    }

    public function getRDVByPatientId(string $id): array
    {
        $rdvs = [];
        foreach ($this->rdvs as $rdv) {
            if ($rdv->getPatientId() === $id) {
                $rdvs[] = $rdv;
            }
        }
        return $rdvs;
    }
}