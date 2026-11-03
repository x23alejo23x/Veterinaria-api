<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Repositories;

use App\Domain\FollowUp\DTOs\FollowUpDTO;
use App\Domain\FollowUp\Entities\FollowUp as FollowUpEntity;
use App\Domain\FollowUp\Repositories\FollowUpRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\Models\FollowUp as FollowUpModel;
use DateTimeImmutable;

final class EloquentFollowUpRepository implements FollowUpRepositoryInterface
{
    public function findById(int $id): ?FollowUpEntity
    {
        $model = FollowUpModel::find($id);
        return $model ? $this->toEntity($model) : null;
    }

    public function findAll(int $page = 1, int $perPage = 20, ?string $status = null): array
    {
        $query = FollowUpModel::query();

        if ($status) {
            $query->where('status', $status);
        }

        $paginator = $query->orderBy('created_at', 'desc')->paginate($perPage, ['*'], 'page', $page);

        return [
            'items'    => array_map([$this, 'toEntity'], $paginator->items()),
            'total'    => $paginator->total(),
            'page'     => $paginator->currentPage(),
            'per_page' => $paginator->perPage(),
        ];
    }

    public function findByPatient(int $patientId): array
    {
        return FollowUpModel::where('patient_id', $patientId)
            ->orderBy('date', 'desc')
            ->get()
            ->map([$this, 'toEntity'])
            ->all();
    }

    public function save(FollowUpEntity $followUp): FollowUpEntity
    {
        $model = FollowUpModel::create([
            'patient_id' => $followUp->patientId,
            'owner_id'   => $followUp->ownerId,
            'date'       => $followUp->date->format('Y-m-d'),
            'type'       => $followUp->type,
            'status'     => $followUp->status,
            'notes'      => $followUp->notes,
        ]);

        return $this->toEntity($model);
    }

    public function update(int $id, FollowUpDTO $dto): FollowUpEntity
    {
        $model = FollowUpModel::findOrFail($id);
        $model->update([
            'patient_id' => $dto->patientId,
            'owner_id'   => $dto->ownerId,
            'date'       => $dto->date,
            'type'       => $dto->type,
            'status'     => $dto->status,
            'notes'      => $dto->notes,
        ]);

        return $this->toEntity($model->fresh());
    }

    public function delete(int $id): void
    {
        FollowUpModel::findOrFail($id)->delete();
    }

    private function toEntity(FollowUpModel $model): FollowUpEntity
    {
        return new FollowUpEntity(
            id: $model->id,
            patientId: $model->patient_id,
            ownerId: $model->owner_id,
            date: new DateTimeImmutable($model->date->toDateString()),
            type: $model->type,
            status: $model->status,
            notes: $model->notes,
            createdAt: new DateTimeImmutable($model->created_at->toDateTimeString()),
        );
    }
}
