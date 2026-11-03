<?php

declare(strict_types=1);

namespace App\Application\MedicalHistory\UseCases;

use App\Domain\MedicalHistory\DTOs\MedicalHistoryDTO;
use App\Domain\MedicalHistory\Entities\MedicalHistory;
use App\Domain\MedicalHistory\Repositories\MedicalHistoryRepositoryInterface;
use DateTimeImmutable;

final class CreateMedicalHistory
{
    public function __construct(
        private readonly MedicalHistoryRepositoryInterface $repository,
    ) {}

    public function execute(MedicalHistoryDTO $dto): MedicalHistory
    {
        $record = MedicalHistory::create(
            patientId: $dto->patientId,
            date: new DateTimeImmutable($dto->date),
            type: $dto->type,
            diagnosis: $dto->diagnosis,
            treatment: $dto->treatment,
            vetId: $dto->vetId,
            notes: $dto->notes,
            weight: $dto->weight,
            temperature: $dto->temperature,
        );

        return $this->repository->save($record);
    }
}
