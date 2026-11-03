<?php

declare(strict_types=1);

namespace App\Application\ExamCatalog\UseCases;

use App\Domain\ExamCatalog\DTOs\ExamCatalogDTO;
use App\Domain\ExamCatalog\Entities\ExamCatalog;
use App\Domain\ExamCatalog\Repositories\ExamCatalogRepositoryInterface;

final class UpdateExamCatalog
{
    public function __construct(
        private readonly ExamCatalogRepositoryInterface $repository,
    ) {}

    public function execute(int $id, ExamCatalogDTO $dto): ExamCatalog
    {
        return $this->repository->update($id, $dto);
    }
}
