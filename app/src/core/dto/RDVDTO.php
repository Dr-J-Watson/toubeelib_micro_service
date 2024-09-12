<?php

namespace toubeelib\core\dto;

class RDVDTO extends DTO{
    protected ID $ID;
    protected DateTime $dateHeure;
    protected int $duree = 30;
    protected String $practicienID;
    protected String $patientID;
    protected String $statut;
    protected String $type;

    public function __construct(RDV $rdv){
        $this->ID = $rdv->getID();
        $this->dateHeure = $rdv->dateHeure;
        $this->duree = $rdv->duree;
        $this->practicienID = $rdv->practicienID;
        $this->patientID = $rdv->patientID;
        $this->statut = $rdv->statut;
        $this->type = $rdv->type;
    }
}