<?php

declare(strict_types=1);

namespace App\Domain\Prescription\Repositories;

use App\Domain\Prescription\DTOs\PrescriptionDTO;
use App\Domain\Prescription\Entities\Prescription;

interface PrescriptionRepositoryInterface
{
    public function findById(int $id): ?Prescription;
    public function findAll(int $page = 1, int $perPage = 20, ?int $patientId = null, ?int $medicationId = null): array;
    public function save(Prescription $prescription): Prescription;
    public function update(int $id, PrescriptionDTO $dto): Prescription;
    public function delete(int $id): void;
}
