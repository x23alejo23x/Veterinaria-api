<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Repositories;

use App\Domain\Patient\DTOs\PatientDTO;
use App\Domain\Patient\Entities\Patient as PatientEntity;
use App\Domain\Patient\Repositories\PatientRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\Models\Patient as PatientModel;
use DateTimeImmutable;

final class EloquentPatientRepository implements PatientRepositoryInterface
{
    public function findById(int $id): ?PatientEntity
    {
        $model = PatientModel::find($id);
        return $model ? $this->toEntity($model) : null;
    }

    public function findAll(int $page = 1, int $perPage = 20, ?string $search = null): array
    {
        $query = PatientModel::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('species', 'like', "%{$search}%")
                  ->orWhere('breed', 'like', "%{$search}%");
            });
        }

        $paginator = $query->orderBy('created_at', 'desc')->paginate($perPage, ['*'], 'page', $page);

        return [
            'items' => array_map([$this, 'toEntity'], $paginator->items()),
            'total' => $paginator->total(),
            'page'  => $paginator->currentPage(),
            'per_page' => $paginator->perPage(),
        ];
    }

    public function save(PatientEntity $patient): PatientEntity
    {
        $model = PatientModel::create([
            'name'         => $patient->name,
            'species'      => $patient->species,
            'breed'        => $patient->breed,
            'age'          => $patient->age,
            'weight'       => $patient->weight,
            'owner_id'     => $patient->ownerId,
            'status'       => $patient->status,
            'avatar_color' => $patient->avatarColor,
            'next_visit'   => $patient->nextVisit?->format('Y-m-d'),
        ]);

        return $this->toEntity($model);
    }

    public function update(int $id, PatientDTO $dto): PatientEntity
    {
        $model = PatientModel::findOrFail($id);
        $model->update([
            'name'         => $dto->name,
            'species'      => $dto->species,
            'breed'        => $dto->breed,
            'age'          => $dto->age,
            'weight'       => $dto->weight,
            'owner_id'     => $dto->ownerId,
            'status'       => $dto->status,
            'avatar_color' => $dto->avatarColor,
            'next_visit'   => $dto->nextVisit,
        ]);

        return $this->toEntity($model->fresh());
    }

    public function delete(int $id): void
    {
        PatientModel::findOrFail($id)->delete();
    }

    public function existsById(int $id): bool
    {
        return PatientModel::where('id', $id)->exists();
    }

    private function toEntity(PatientModel $model): PatientEntity
    {
        return new PatientEntity(
            id: $model->id,
            name: $model->name,
            species: $model->species,
            breed: $model->breed,
            age: $model->age,
            weight: $model->weight,
            ownerId: $model->owner_id,
            status: $model->status,
            avatarColor: $model->avatar_color,
            nextVisit: $model->next_visit ? new DateTimeImmutable($model->next_visit->toDateString()) : null,
            createdAt: new DateTimeImmutable($model->created_at->toDateTimeString()),
        );
    }
}
