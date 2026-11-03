<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Repositories;

use App\Domain\Medication\DTOs\MedicationDTO;
use App\Domain\Medication\Entities\Medication as MedicationEntity;
use App\Domain\Medication\Repositories\MedicationRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\Models\Medication as MedicationModel;
use DateTimeImmutable;

final class EloquentMedicationRepository implements MedicationRepositoryInterface
{
    public function findById(int $id): ?MedicationEntity
    {
        $model = MedicationModel::find($id);
        return $model ? $this->toEntity($model) : null;
    }

    public function findAll(int $page = 1, int $perPage = 20, ?string $search = null): array
    {
        $query = MedicationModel::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%")
                  ->orWhere('supplier', 'like', "%{$search}%");
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

    public function findLowStock(int $threshold = 10): array
    {
        return MedicationModel::where('stock', '<=', $threshold)
            ->orderBy('stock', 'asc')
            ->get()
            ->map([$this, 'toEntity'])
            ->all();
    }

    public function save(MedicationEntity $medication): MedicationEntity
    {
        $model = MedicationModel::create([
            'name'        => $medication->name,
            'category'    => $medication->category,
            'stock'       => $medication->stock,
            'unit'        => $medication->unit,
            'price'       => $medication->price,
            'supplier'    => $medication->supplier,
            'expiry_date' => $medication->expiryDate?->format('Y-m-d'),
            'status'      => $medication->status,
        ]);

        return $this->toEntity($model);
    }

    public function update(int $id, MedicationDTO $dto): MedicationEntity
    {
        $model = MedicationModel::findOrFail($id);
        $model->update([
            'name'        => $dto->name,
            'category'    => $dto->category,
            'stock'       => $dto->stock,
            'unit'        => $dto->unit,
            'price'       => $dto->price,
            'supplier'    => $dto->supplier,
            'expiry_date' => $dto->expiryDate,
            'status'      => $dto->status,
        ]);

        return $this->toEntity($model->fresh());
    }

    public function delete(int $id): void
    {
        MedicationModel::findOrFail($id)->delete();
    }

    private function toEntity(MedicationModel $model): MedicationEntity
    {
        return new MedicationEntity(
            id: $model->id,
            name: $model->name,
            category: $model->category,
            stock: $model->stock,
            unit: $model->unit,
            price: $model->price,
            supplier: $model->supplier,
            expiryDate: $model->expiry_date ? new DateTimeImmutable($model->expiry_date->toDateString()) : null,
            status: $model->status,
            createdAt: new DateTimeImmutable($model->created_at->toDateTimeString()),
        );
    }
}
