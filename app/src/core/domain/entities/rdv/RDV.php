<?php

namespace toubeelib\core\domain\entities\rdv;

use toubeelib\core\domain\entities\Entity;

class RDV extends Entity{
    
    protected DateTime dateHeure;
    protected int duree = 30;
    protected String practicienID;
    protected String patientID;
    protected String statut;
    protected String type;

    public function __construct(DateTime $dateHeure, String $practicienID,
    String $patientID, String $type){
        $this->dateHeure = $dateHeure;
        $this->practicienID = $practicienID;
        $this->patientID = $patientID;
        $this->statut = 'OK';
        $this->type = $type;
    }

    public function setStatut(String $statut){
        $this->statut = $statut;
    }

    public function toDTO(): RDVDTO{
        return new RDVDTO($this);
    }




}