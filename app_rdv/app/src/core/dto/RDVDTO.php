<?php

namespace app_rdv\core\dto;
use app_rdv\core\domain\entities\rdv\RDV;

class RDVDTO extends DTO implements \JsonSerializable{
    protected String $ID;
    protected \DateTimeInterface $dateHeure;
    protected int $duree = 30;
    protected PraticienDTO $praticien;
    protected String $patientID;
    protected String $statut;
    protected String $type;

    public function __construct(RDV $rdv){
        $this->ID = $rdv->ID;
        $this->dateHeure = $rdv->dateHeure;
        $this->duree = $rdv->duree;
        $this->praticien = $rdv->praticien ?? null;
        $this->patientID = $rdv->patientID;
        $this->statut = $rdv->statut;
        $this->type = $rdv->type;
    }

    public function jsonSerialize(): array{
        return [
            'ID' => $this->ID,
            'dateHeure' => $this->dateHeure->format('Y-m-d H:i:s'),
            'duree' => $this->duree,
            'patientID' => $this->patientID,
            'statut' => $this->statut,
            'type' => $this->type,
            'praticien' => $this->praticien
        ];
    }

    public function setPraticien(PraticienDTO $praticien): void {
        $this->praticien = $praticien;
    }
}