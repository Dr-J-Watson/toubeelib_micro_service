<?php

namespace toubeelib\infrastructure\repositories;
use Ramsey\Uuid\Uuid;
use toubeelib\core\domain\entities\praticien\Praticien;
use toubeelib\core\domain\entities\praticien\Specialite;
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

    public function save(Praticien $praticien): string
    {
        // TODO: Implement save() method.
        return 'implement save';
    }

    public function getSpecialiteById(string $id): Specialite
    {
        // TODO: Implement getSpecialiteById() method.
    }
}