<?php

namespace app_rdv\core\dto;

use app_rdv\core\domain\entities\praticien\Praticien;
use app_rdv\core\dto\DTO;

class PraticienDTO extends DTO implements \JsonSerializable
{
    protected string $ID;
    protected string $nom;
    protected string $prenom;
    protected string $adresse;
    protected string $tel;
    protected ?string $specialite;

    public function __construct(Praticien $p)
    {
        $this->ID = $p->getID();
        $this->nom = $p->nom;
        $this->prenom = $p->prenom;
        $this->adresse = $p->adresse;
        $this->tel = $p->tel;
        $this->specialite= $p->specialite ?? null;
    }

    public function jsonSerialize(): array
    {
        return [
            'ID' => $this->ID,
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'adresse' => $this->adresse,
            'tel' => $this->tel,
            'specialite_label' => $this->specialite
        ];
    }


}