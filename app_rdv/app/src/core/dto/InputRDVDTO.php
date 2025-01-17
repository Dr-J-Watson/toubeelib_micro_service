<?php

namespace app_rdv\core\dto;

class InputRDVDTO extends DTO{
    protected \DateTimeImmutable $dateHeure;
    protected int $duree = 30;
    protected String $praticienID;
    protected String $patientID;
    protected String $type;
    protected String $statut;

    public function __construct(\DateTimeImmutable $dateHeure, String $praticienID, String $patientID, String $type, String $statut){
        $this->dateHeure = $dateHeure;
        $this->praticienID = $praticienID;
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

    public function getPraticienID(): string {
        return $this->praticienID;
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