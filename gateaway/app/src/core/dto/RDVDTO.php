<?php

namespace toubeelib\core\dto;
use toubeelib\core\domain\entities\rdv\RDV;

class RDVDTO extends DTO implements \JsonSerializable{
    protected String $ID;
    protected \DateTimeInterface $dateHeure;
    protected int $duree = 30;
    protected String $practicienID;
    protected String $patientID;
    protected String $statut;
    protected String $type;

    public function __construct(RDV $rdv){
        $this->ID = $rdv->ID;
        $this->dateHeure = $rdv->dateHeure;
        $this->duree = $rdv->duree;
        $this->practicienID = $rdv->practicienID;
        $this->patientID = $rdv->patientID;
        $this->statut = $rdv->statut;
        $this->type = $rdv->type;
    }

    public function jsonSerialize(): array{
        return [
            'ID' => $this->ID,
            'dateHeure' => $this->dateHeure->format('Y-m-d H:i:s'),
            'duree' => $this->duree,
            'practicienID' => $this->practicienID,
            'patientID' => $this->patientID,
            'statut' => $this->statut,
            'type' => $this->type
        ];
    }
}