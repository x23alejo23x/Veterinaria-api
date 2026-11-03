<?php

declare(strict_types=1);

namespace App\Domain\MedicalHistory\Repositories;

use App\Domain\MedicalHistory\DTOs\MedicalHistoryDTO;
use App\Domain\MedicalHistory\Entities\MedicalHistory;

interface MedicalHistoryRepositoryInterface
{
    public function findById(int $id): ?MedicalHistory;

    /** @return array{items: MedicalHistory[], total: int} */
    public function findAll(int $page = 1, int $perPage = 20): array;

    public function findByPatient(int $patientId): array;

    public function save(MedicalHistory $history): MedicalHistory;

    public function update(int $id, MedicalHistoryDTO $dto): MedicalHistory;

    public function delete(int $id): void;
}
