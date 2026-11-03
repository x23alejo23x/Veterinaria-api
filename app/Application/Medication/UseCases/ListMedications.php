<?php

declare(strict_types=1);

namespace App\Application\Medication\UseCases;

use App\Domain\Medication\Repositories\MedicationRepositoryInterface;

final class ListMedications
{
    public function __construct(
        private readonly MedicationRepositoryInterface $repository,
    ) {}

    public function execute(int $page = 1, int $perPage = 20, ?string $search = null): array
    {
        return $this->repository->findAll($page, $perPage, $search);
    }
}
