<?php

declare(strict_types=1);

namespace App\Domain\Medication\Repositories;

use App\Domain\Medication\DTOs\MedicationDTO;
use App\Domain\Medication\Entities\Medication;

interface MedicationRepositoryInterface
{
    public function findById(int $id): ?Medication;

    /** @return array{items: Medication[], total: int} */
    public function findAll(int $page = 1, int $perPage = 20, ?string $search = null): array;

    public function save(Medication $medication): Medication;

    public function update(int $id, MedicationDTO $dto): Medication;

    public function delete(int $id): void;

    public function findLowStock(int $threshold = 10): array;
}
