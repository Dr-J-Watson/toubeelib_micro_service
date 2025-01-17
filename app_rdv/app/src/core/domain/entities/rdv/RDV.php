<?php

namespace app_rdv\core\domain\entities\rdv;

use app_rdv\core\domain\entities\Entity;
use app_rdv\core\dto\PraticienDTO;
use app_rdv\core\dto\RDVDTO;

class RDV extends Entity{
    protected \DateTimeInterface $dateHeure;
    protected int $duree = 30;
    protected String $praticienID;
    protected PraticienDTO | null $praticien;
    protected String $patientID;
    protected String $statut;
    protected String $type;
//'p1', 'pa1', 'A', \DateTimeImmutable::createFromFormat('Y-m-d H:i','2024-09-02 09:00')
    public function __construct(String $praticienID, String $patientID,String $type, \DateTimeInterface $dateHeure, PraticienDTO | null $praticien = null){
        $this->praticienID = $praticienID;
        $this->dateHeure = $dateHeure;
        $this->patientID = $patientID;
        $this->statut = 'OK';
        $this->type = $type;
        $this->praticien = $praticien;
    }

    public function __toString(){
        return "RDV: $this->id, $this->praticien, $this->patientID, $this->type, $this->dateHeure, $this->statut";
    }
    public function setStatut(String $statut){
        $this->statut = $statut;
    }

    public function setPraticien(PraticienDTO $praticien){
        $this->praticien = $praticien;
    }

    public function toDTO(): RDVDTO{
        return new RDVDTO($this);
    }

    public function update($dh, $praticienDTO, $type, $statut){
        $this->dateHeure = $dh;
        $this->praticien = $praticienDTO;
        $this->type = $type;
        $this->statut = $statut;
    }

    public function getPraticienId(){
        return $this->praticienID;
    }
}