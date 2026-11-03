<?php

declare(strict_types=1);

namespace App\Application\Medication\UseCases;

use App\Domain\Medication\DTOs\MedicationDTO;
use App\Domain\Medication\Entities\Medication;
use App\Domain\Medication\Repositories\MedicationRepositoryInterface;
use DateTimeImmutable;

final class CreateMedication
{
    public function __construct(
        private readonly MedicationRepositoryInterface $repository,
    ) {}

    public function execute(MedicationDTO $dto): Medication
    {
        $medication = Medication::create(
            name: $dto->name,
            category: $dto->category,
            stock: $dto->stock,
            unit: $dto->unit,
            price: $dto->price,
            supplier: $dto->supplier,
            expiryDate: $dto->expiryDate ? new DateTimeImmutable($dto->expiryDate) : null,
            status: $dto->status,
        );

        return $this->repository->save($medication);
    }
}
