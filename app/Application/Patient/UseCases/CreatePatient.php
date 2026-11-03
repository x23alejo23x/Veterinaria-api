<?php

declare(strict_types=1);

namespace App\Application\Patient\UseCases;

use App\Domain\Patient\DTOs\PatientDTO;
use App\Domain\Patient\Entities\Patient;
use App\Domain\Patient\Repositories\PatientRepositoryInterface;
use DateTimeImmutable;

final class CreatePatient
{
    public function __construct(
        private readonly PatientRepositoryInterface $repository,
    ) {}

    public function execute(PatientDTO $dto): Patient
    {
        $patient = Patient::create(
            name: $dto->name,
            species: $dto->species,
            breed: $dto->breed,
            age: $dto->age,
            weight: $dto->weight,
            ownerId: $dto->ownerId,
            status: $dto->status,
            avatarColor: $dto->avatarColor,
            nextVisit: $dto->nextVisit ? new DateTimeImmutable($dto->nextVisit) : null,
        );

        return $this->repository->save($patient);
    }
}
