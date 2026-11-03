<?php

declare(strict_types=1);

namespace App\Application\MedicalHistory\UseCases;

use App\Domain\MedicalHistory\Repositories\MedicalHistoryRepositoryInterface;

final class ListMedicalHistories
{
    public function __construct(
        private readonly MedicalHistoryRepositoryInterface $repository,
    ) {}

    public function execute(int $page = 1, int $perPage = 20): array
    {
        return $this->repository->findAll($page, $perPage);
    }
}
