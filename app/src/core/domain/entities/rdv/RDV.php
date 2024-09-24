<?php

namespace toubeelib\core\domain\entities\rdv;

use toubeelib\core\domain\entities\Entity;
use toubeelib\core\dto\RDVDTO;

class RDV extends Entity{
    protected \DateTimeInterface $dateHeure;
    protected int $duree = 30;
    protected String $practicienID;
    protected String $patientID;
    protected String $statut;
    protected String $type;
//'p1', 'pa1', 'A', \DateTimeImmutable::createFromFormat('Y-m-d H:i','2024-09-02 09:00')
    public function __construct(String $practicienID,String $patientID,String $type, \DateTimeInterface $dateHeure){
        $this->dateHeure = $dateHeure;
        $this->practicienID = $practicienID;
        $this->patientID = $patientID;
        $this->statut = 'OK';
        $this->type = $type;
    }

    public function __toString(){
        return "RDV: $this->id, $this->practicienID, $this->patientID, $this->type, $this->dateHeure, $this->statut";
    }
    public function setStatut(String $statut){
        $this->statut = $statut;
    }

    public function toDTO(): RDVDTO{
        return new RDVDTO($this);
    }

    public function update($dh, $pid, $tid, $type, $statut){
        $this->dateHeure = $dh;
        $this->practicienID = $pid;
        $this->type = $tid;
        $this->type = $type;
        $this->statut = $statut;
    }
}