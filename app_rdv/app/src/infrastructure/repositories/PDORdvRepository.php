<?php

namespace app_rdv\infrastructure\repositories;
use app_rdv\core\dto\RDVDTO;
use app_rdv\core\repositoryInterfaces\RDVRepositoryInterface;
use app_rdv\core\domain\entities\rdv\RDV;
use PDO;


class PDORdvRepository implements RDVRepositoryInterface
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function save(RDV $rdv): RDV
    {
        
        $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM rdv WHERE id = :id');
        $stmt->execute(['id' => $rdv->getId()]);
        $exists = $stmt->fetchColumn();
    
        if ($exists) {
            return $this->update($rdv);
        } else {
            
            $stmt = $this->pdo->prepare('INSERT INTO rdv (id, praticien_id, patient_id, type_id, date_heure, statut) VALUES (:id, :praticien_id, :patient_id, :type_id, :date_heure, :statut)');
            $stmt->execute([
                'id' => $rdv->getId(),
                'praticien_id' => trim($rdv->getPraticienId()),
                'patient_id' => trim($rdv->patientID),
                'type_id' => trim($rdv->type),
                'date_heure' => trim($rdv->dateHeure->format('Y-m-d H:i')),
                'statut' => trim($rdv->statut),
            ]);
            return $rdv;
        }
    }

    public function update(RDV $rdv): RDV
    {
        $stmt = $this->pdo->prepare('UPDATE rdv SET praticien_id = :praticien_id, patient_id = :patient_id, type_id = :type_id, date_heure = :date_heure, statut = :statut WHERE id = :id');
        $stmt->execute([
            'id' => $rdv->getId(),
            'praticien_id' => $rdv->getPraticienId(),
            'patient_id' => $rdv->patientID,
            'type_id' => $rdv->type,
            'date_heure' => $rdv->dateHeure->format('Y-m-d H:i'),
            'statut' => $rdv->statut,
        ]);
        return $rdv;
    }
    

    public function getRDVById(string $id): RDV
    {
        $stmt = $this->pdo->prepare('SELECT * FROM rdv WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        if (!$row) {
            throw new \app_rdv\core\repositoryInterfaces\RepositoryEntityNotFoundException("RDV with id $id not found");
        }
        $rdv = new RDV($row['praticien_id'], $row['patient_id'], $row['type_id'], new \DateTimeImmutable($row['date_heure']));
        $rdv->setID($row['id']);
        return $rdv;
    }

    /**
     * @return RDV[]
     */
    public function getRDVByPatientId(string $id): array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM rdv WHERE patient_id = :id');
        $stmt->execute(['id' => $id]);
        $rows = $stmt->fetchAll();
        $rdvs = [];
        foreach ($rows as $row) {
            $rdv = new RDV($row['praticien_id'], $row['patient_id'], $row['type'], new \DateTimeImmutable($row['date_heure']));
            $rdv->setID($row['id']);
            $rdvs[] = $rdv;
        }
        return $rdvs;
    }

    /**
     * @return RDVDTO[]
     * @throws \DateMalformedStringException
     */
    public function getRDVByPraticienId(string $id, ?string $dateDebut, ?string $dateFin): array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM rdv WHERE praticien_id = :id AND date_heure >= :date_debut AND date_heure <= :date_fin');
        $stmt->execute(['id' => $id, 'date_debut' => $dateDebut, 'date_fin' => $dateFin]);
        $rows = $stmt->fetchAll();
        $rdvs = [];
        foreach ($rows as $row) {
            $rdv = new RDV($row['praticien_id'], $row['patient_id'], $row['type_id'], new \DateTimeImmutable($row['date_heure']));
            $rdv->setID($row['id']);
            $rdvs[] = $rdv->toDTO();
        }
        return $rdvs;
    }

}