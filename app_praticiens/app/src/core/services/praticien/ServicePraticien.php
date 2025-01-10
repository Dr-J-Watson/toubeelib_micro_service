<?php

namespace app_praticiens\core\services\praticien;

use Ramsey\Uuid\Uuid;
use Respect\Validation\Exceptions\NestedValidationException;
use app_praticiens\core\domain\entities\praticien\Praticien;
use app_praticiens\core\dto\InputPraticienDTO;
use app_praticiens\core\dto\PraticienDTO;
use app_praticiens\core\dto\SpecialiteDTO;
use app_praticiens\core\repositoryInterfaces\PraticienRepositoryInterface;
use app_praticiens\core\repositoryInterfaces\RepositoryEntityNotFoundException;

class ServicePraticien implements ServicePraticienInterface
{
    private PraticienRepositoryInterface $praticienRepository;

    public function __construct(PraticienRepositoryInterface $praticienRepository)
    {
        $this->praticienRepository = $praticienRepository;
    }

    public function createPraticien(InputPraticienDTO $p): PraticienDTO
    {
        try {
            $praticien = new Praticien($p->nom, $p->prenom, $p->adresse, $p->tel);
            $praticien->setID(Uuid::uuid4());
            $praticien->setSpecialite($this->praticienRepository->getSpecialiteById($p->specialite));
            $SavedPraticien = $this->praticienRepository->save($praticien);
        } catch(NestedValidationException $e) {
            throw new ServicePraticienInvalidDataException($e->getMessages());
        }
        return $SavedPraticien->toDTO();
    }

    public function getPraticienById(string $id): PraticienDTO
    {
        try {
            $praticien = $this->praticienRepository->getPraticienById($id);
            return new PraticienDTO($praticien);
        } catch(RepositoryEntityNotFoundException $e) {
            throw new ServicePraticienInvalidDataException('invalid Praticien ID');
        }
    }

    public function getSpecialiteById(string $id): SpecialiteDTO
    {
        try {
            $specialite = $this->praticienRepository->getSpecialiteById($id);
            return $specialite->toDTO();
        } catch(RepositoryEntityNotFoundException $e) {
            throw new ServicePraticienInvalidDataException('invalid Specialite ID');
        }
    }

    public function getPraticiens(string $nom, string $ville, string $specialite, int $page ): array
    {
        $praticiens = $this->praticienRepository->getPraticiens($nom, $ville, $specialite, $page);
        $praticiensDTO = [];
        foreach($praticiens as $praticien) {
            $praticiensDTO[] = $praticien->toDTO();
        }
        return $praticiensDTO;
    }

    public function getPraticien(string $id): PraticienDTO
    {
        $praticien = $this->praticienRepository->getPraticienById($id);
        return $praticien->toDTO();
    }
}