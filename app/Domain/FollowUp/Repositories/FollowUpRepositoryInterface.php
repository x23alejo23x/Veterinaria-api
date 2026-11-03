<?php

declare(strict_types=1);

namespace App\Domain\FollowUp\Repositories;

use App\Domain\FollowUp\DTOs\FollowUpDTO;
use App\Domain\FollowUp\Entities\FollowUp;

interface FollowUpRepositoryInterface
{
    public function findById(int $id): ?FollowUp;

    /** @return array{items: FollowUp[], total: int} */
    public function findAll(int $page = 1, int $perPage = 20, ?string $status = null): array;

    public function findByPatient(int $patientId): array;

    public function save(FollowUp $followUp): FollowUp;

    public function update(int $id, FollowUpDTO $dto): FollowUp;

    public function delete(int $id): void;
}
