<?php

declare(strict_types=1);

namespace App\Application\ExamCatalog\UseCases;

use App\Domain\ExamCatalog\Repositories\ExamCatalogRepositoryInterface;

final class DeleteExamCatalog
{
    public function __construct(
        private readonly ExamCatalogRepositoryInterface $repository,
    ) {}

    public function execute(int $id): void
    {
        $this->repository->delete($id);
    }
}
