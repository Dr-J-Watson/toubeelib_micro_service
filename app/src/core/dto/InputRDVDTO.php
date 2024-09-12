<?php

namespace toubeelib\core\dto;

class InputRDVDTO extends DTO{
    protected DateTime $dateHeure;
    protected int $duree = 30;
    protected String $practicienID;
    protected String $patientID;
    protected String $type;

    public function __construct(DateTime $dateHeure, String $practicienID, String $patientID, String $type){
        $this->dateHeure = $dateHeure;
        $this->practicienID = $practicienID;
        $this->patientID = $patientID;
        $this->type = $type;
    }
}