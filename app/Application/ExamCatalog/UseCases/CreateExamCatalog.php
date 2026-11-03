<?php

declare(strict_types=1);

namespace App\Application\ExamCatalog\UseCases;

use App\Domain\ExamCatalog\DTOs\ExamCatalogDTO;
use App\Domain\ExamCatalog\Entities\ExamCatalog;
use App\Domain\ExamCatalog\Repositories\ExamCatalogRepositoryInterface;

final class CreateExamCatalog
{
    public function __construct(
        private readonly ExamCatalogRepositoryInterface $repository,
    ) {}

    public function execute(ExamCatalogDTO $dto): ExamCatalog
    {
        $exam = ExamCatalog::create(
            name: $dto->name,
            category: $dto->category,
            price: $dto->price,
        );

        return $this->repository->save($exam);
    }
}
