<?php

namespace app_praticiens\core\dto;

use app_praticiens\core\domain\entities\praticien\Praticien;
use app_praticiens\core\dto\DTO;

class PraticienDTO extends DTO implements \JsonSerializable
{
    protected string $ID;
    protected string $nom;
    protected string $prenom;
    protected string $adresse;
    protected string $tel;
    protected string $specialite_label;

    public function __construct(Praticien $p)
    {
        $this->ID = $p->getID();
        $this->nom = $p->nom;
        $this->prenom = $p->prenom;
        $this->adresse = $p->adresse;
        $this->tel = $p->tel;
        $this->specialite_label = $p->specialite->label;
    }

    public function jsonSerialize(): array
    {
        return [
            'ID' => $this->ID,
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'adresse' => $this->adresse,
            'tel' => $this->tel,
            'specialite_label' => $this->specialite_label
        ];
    }


}