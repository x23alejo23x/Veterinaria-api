<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Repositories;

use App\Domain\ExamCatalog\DTOs\ExamCatalogDTO;
use App\Domain\ExamCatalog\Entities\ExamCatalog as ExamCatalogEntity;
use App\Domain\ExamCatalog\Repositories\ExamCatalogRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\Models\ExamCatalog as ExamCatalogModel;

final class EloquentExamCatalogRepository implements ExamCatalogRepositoryInterface
{
    public function findById(int $id): ?ExamCatalogEntity
    {
        $model = ExamCatalogModel::find($id);
        return $model ? $this->toEntity($model) : null;
    }

    public function findAll(int $page = 1, int $perPage = 50, ?string $search = null): array
    {
        $query = ExamCatalogModel::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'ilike', "%{$search}%")
                  ->orWhere('category', 'ilike', "%{$search}%");
            });
        }

        $paginator = $query->orderBy('name')->paginate($perPage, ['*'], 'page', $page);

        return [
            'items'    => collect($paginator->items())->map(fn($m) => $this->toEntity($m))->all(),
            'total'    => $paginator->total(),
            'page'     => $paginator->currentPage(),
            'pageSize' => $paginator->perPage(),
        ];
    }

    public function save(ExamCatalogEntity $exam): ExamCatalogEntity
    {
        $model = ExamCatalogModel::create([
            'name'     => $exam->name,
            'category' => $exam->category,
            'price'    => $exam->price,
        ]);

        return $this->toEntity($model);
    }

    public function update(int $id, ExamCatalogDTO $dto): ExamCatalogEntity
    {
        $model = ExamCatalogModel::findOrFail($id);
        $model->update([
            'name'     => $dto->name,
            'category' => $dto->category,
            'price'    => $dto->price,
        ]);

        return $this->toEntity($model->fresh());
    }

    public function delete(int $id): void
    {
        ExamCatalogModel::findOrFail($id)->delete();
    }

    private function toEntity(ExamCatalogModel $model): ExamCatalogEntity
    {
        return new ExamCatalogEntity(
            id:        $model->id,
            name:      $model->name,
            category:  $model->category,
            price:     (float) $model->price,
            createdAt: $model->created_at
                ? new \DateTimeImmutable($model->created_at->toIso8601String())
                : null,
        );
    }
}
