<?php

declare(strict_types=1);

namespace App\Domain\ExamCatalog\Repositories;

use App\Domain\ExamCatalog\DTOs\ExamCatalogDTO;
use App\Domain\ExamCatalog\Entities\ExamCatalog;

interface ExamCatalogRepositoryInterface
{
    public function findById(int $id): ?ExamCatalog;

    /** @return array{items: ExamCatalog[], total: int} */
    public function findAll(int $page = 1, int $perPage = 50, ?string $search = null): array;

    public function save(ExamCatalog $exam): ExamCatalog;

    public function update(int $id, ExamCatalogDTO $dto): ExamCatalog;

    public function delete(int $id): void;
}
