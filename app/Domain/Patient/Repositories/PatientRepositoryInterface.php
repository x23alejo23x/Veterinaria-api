<?php

declare(strict_types=1);

namespace App\Domain\Patient\Repositories;

use App\Domain\Patient\DTOs\PatientDTO;
use App\Domain\Patient\Entities\Patient;

interface PatientRepositoryInterface
{
    public function findById(int $id): ?Patient;

    /** @return array{items: Patient[], total: int} */
    public function findAll(int $page = 1, int $perPage = 20, ?string $search = null): array;

    public function save(Patient $patient): Patient;

    public function update(int $id, PatientDTO $dto): Patient;

    public function delete(int $id): void;

    public function existsById(int $id): bool;
}
