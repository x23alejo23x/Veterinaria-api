<?php

declare(strict_types=1);

namespace App\Application\Prescription\UseCases;

use App\Domain\Prescription\DTOs\PrescriptionDTO;
use App\Domain\Prescription\Entities\Prescription;
use App\Domain\Prescription\Repositories\PrescriptionRepositoryInterface;

final class CreatePrescription
{
    public function __construct(private readonly PrescriptionRepositoryInterface $repository) {}

    public function execute(PrescriptionDTO $dto): Prescription
    {
        $prescription = Prescription::create(
            patientId: $dto->patientId,
            medicationId: $dto->medicationId,
            dose: $dto->dose,
            frequency: $dto->frequency,
            duration: $dto->duration,
            notes: $dto->notes,
            status: $dto->status,
            vet: $dto->vet,
            date: $dto->date,
        );

        return $this->repository->save($prescription);
    }
}
