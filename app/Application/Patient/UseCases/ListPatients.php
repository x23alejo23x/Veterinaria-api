<?php

declare(strict_types=1);

namespace App\Application\Patient\UseCases;

use App\Domain\Patient\Repositories\PatientRepositoryInterface;

final class ListPatients
{
    public function __construct(
        private readonly PatientRepositoryInterface $repository,
    ) {}

    public function execute(int $page = 1, int $perPage = 20, ?string $search = null): array
    {
        return $this->repository->findAll($page, $perPage, $search);
    }
}
