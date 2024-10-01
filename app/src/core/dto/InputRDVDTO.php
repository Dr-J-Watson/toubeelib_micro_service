<?php

namespace toubeelib\core\dto;

class InputRDVDTO extends DTO{
    protected \DateTimeImmutable $dateHeure;
    protected int $duree = 30;
    protected String $practicienID;
    protected String $patientID;
    protected String $type;
    protected String $statut;

    public function __construct(\DateTimeImmutable $dateHeure, String $practicienID, String $patientID, String $type, String $statut){
        $this->dateHeure = $dateHeure;
        $this->practicienID = $practicienID;
        $this->patientID = $patientID;
        $this->type = $type;
        $this->statut = $statut ?? 'OK';
    }

    public function getDateHeure(): \DateTimeImmutable {
        return $this->dateHeure;
    }

    public function getDuree(): int {
        return $this->duree;
    }

    public function getPracticienID(): string {
        return $this->practicienID;
    }

    public function getPatientID(): string {
        return $this->patientID;
    }

    public function getType(): string {
        return $this->type;
    }
    public function getStatut(): string {
        return $this->statut;
    }
}