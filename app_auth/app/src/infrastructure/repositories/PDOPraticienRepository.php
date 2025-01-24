<?php

namespace app_auth\infrastructure\repositories;
use Ramsey\Uuid\Uuid;
use app_auth\core\domain\entities\praticien\Praticien;
use app_auth\core\domain\entities\praticien\Specialite;
use app_auth\core\dto\PraticienDTO;
use app_auth\core\repositoryInterfaces\PraticienRepositoryInterface;
use app_auth\core\repositoryInterfaces\RepositoryEntityNotFoundException;
use PDO;

class PDOPraticienRepository implements PraticienRepositoryInterface
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
        $praticien = new Praticien($row['nom'], $row['prenom'], $row['adresse'], $row['tel']);
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

    public function getPraticiens(string $nom, string $ville, string $specialite, int $page = 1): array
    {
        $limit = 5;
        $offset = ($page - 1) * $limit;
    
        $query = 'SELECT * FROM praticien WHERE LOWER(nom) LIKE LOWER(:nom) AND LOWER(adresse) LIKE LOWER(:ville)';
        $params = [
            'nom' => '%' . strtolower($nom) . '%',
            'ville' => '%' . strtolower($ville) . '%'
        ];
    
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        $rows = $stmt->fetchAll();
    
        $praticiens = [];
        foreach ($rows as $row) {
            $praticien = new Praticien($row['nom'], $row['prenom'], $row['adresse'], $row['tel']);
            $praticien->setID($row['id']);
            $specialiteEntity = $this->getSpecialiteById($row['specialite_id']);
            $praticien->setSpecialite($specialiteEntity);
            $praticiens[] = $praticien;
        }
        return $praticiens;
    }
}