<?php

namespace app_rdv\core\domain\entities\praticien;

use app_rdv\core\domain\entities\Entity;
use app_rdv\core\dto\PraticienDTO;

class Praticien extends Entity
{
    protected string $nom;
    protected string $prenom;
    protected string $adresse;
    protected string $tel;
    protected ?string $specialite = null; // version simplifiée : une seule spécialité

    public function __construct(string $nom, string $prenom, string $adresse, string $tel, string | null $specialite = null)
    {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->adresse = $adresse;
        $this->tel = $tel;
        $this->specialite = $specialite;
    }

    public function toDTO(): PraticienDTO
    {
        return new PraticienDTO($this);
    }
}