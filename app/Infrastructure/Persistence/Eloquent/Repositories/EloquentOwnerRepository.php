<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Repositories;

use App\Domain\Owner\DTOs\OwnerDTO;
use App\Domain\Owner\Entities\Owner as OwnerEntity;
use App\Domain\Owner\Repositories\OwnerRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\Models\Owner as OwnerModel;
use DateTimeImmutable;

final class EloquentOwnerRepository implements OwnerRepositoryInterface
{
    public function findById(int $id): ?OwnerEntity
    {
        $model = OwnerModel::find($id);
        return $model ? $this->toEntity($model) : null;
    }

    public function findAll(int $page = 1, int $perPage = 20, ?string $search = null): array
    {
        $query = OwnerModel::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%");
            });
        }

        $paginator = $query->orderBy('created_at', 'desc')->paginate($perPage, ['*'], 'page', $page);

        return [
            'items'    => array_map([$this, 'toEntity'], $paginator->items()),
            'total'    => $paginator->total(),
            'page'     => $paginator->currentPage(),
            'per_page' => $paginator->perPage(),
        ];
    }

    public function save(OwnerEntity $owner): OwnerEntity
    {
        $model = OwnerModel::create([
            'name'  => $owner->name,
            'email' => $owner->email,
            'phone' => $owner->phone,
            'city'  => $owner->city,
        ]);

        return $this->toEntity($model);
    }

    public function update(int $id, OwnerDTO $dto): OwnerEntity
    {
        $model = OwnerModel::findOrFail($id);
        $model->update([
            'name'  => $dto->name,
            'email' => $dto->email,
            'phone' => $dto->phone,
            'city'  => $dto->city,
        ]);

        return $this->toEntity($model->fresh());
    }

    public function delete(int $id): void
    {
        OwnerModel::findOrFail($id)->delete();
    }

    private function toEntity(OwnerModel $model): OwnerEntity
    {
        return new OwnerEntity(
            id: $model->id,
            name: $model->name,
            email: $model->email,
            phone: $model->phone,
            city: $model->city,
            createdAt: new DateTimeImmutable($model->created_at->toDateTimeString()),
        );
    }
}
