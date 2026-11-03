<?php

declare(strict_types=1);

namespace App\Application\ExamCatalog\UseCases;

use App\Domain\ExamCatalog\Repositories\ExamCatalogRepositoryInterface;

final class ListExamCatalog
{
    public function __construct(
        private readonly ExamCatalogRepositoryInterface $repository,
    ) {}

    public function execute(int $page = 1, int $perPage = 50, ?string $search = null): array
    {
        return $this->repository->findAll($page, $perPage, $search);
    }
}
