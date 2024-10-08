<?php

namespace toubeelib\infrastructure\repositories;
use Ramsey\Uuid\Uuid;
use toubeelib\core\domain\entities\praticien\Praticien;
use toubeelib\core\domain\entities\praticien\Specialite;
use toubeelib\core\dto\PraticienDTO;
use toubeelib\core\repositoryInterfaces\PraticienRepositoryInterface;
use toubeelib\core\repositoryInterfaces\RepositoryEntityNotFoundException;
use PDO;

class PDOPraticientRepository implements PraticienRepositoryInterface
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getPraticienById(string $id): Praticien
    {
        $stmt = $this->pdo->prepare('SELECT * FROM praticien WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        if (!$row) {
            throw new RepositoryEntityNotFoundException("Praticien with id $id not found");
        }
        $praticien = new Praticien($row['nom'], $row['prenom'], $row['adresse'], $row['telephone']);
        $praticien->setID($row['id']);
        $specialite = $this->getSpecialiteById($row['specialite_id']);
        $praticien->setSpecialite($specialite);
        return $praticien;
    }

    public function save(Praticien $praticien): Praticien
    {
        $stmt = $this->pdo->prepare('INSERT INTO praticien (id, nom, prenom, adresse, tel, specialite_id) VALUES (:id, :nom, :prenom, :adresse, :tel, :specialite_id)');
        $stmt->execute([
            'id' => Uuid::uuid4()->toString(),
            'nom' => $praticien->nom,
            'prenom' => $praticien->prenom,
            'adresse' => $praticien->adresse,
            'tel' => $praticien->tel,
            'specialite_id' => $praticien->specialite->ID
        ]);
        return $praticien;
    }

    /**
     * @throws RepositoryEntityNotFoundException
     */
    public function getSpecialiteById(string $id): Specialite
    {
        $stmt = $this->pdo->prepare('SELECT * FROM specialite WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        if (!$row) {
            throw new RepositoryEntityNotFoundException("Specialite with id $id not found");
        }
        return new Specialite($row['id'], $row['label'], $row['description']);
    }
}