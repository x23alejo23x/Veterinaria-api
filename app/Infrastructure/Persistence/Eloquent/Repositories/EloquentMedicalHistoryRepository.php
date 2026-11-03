<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Repositories;

use App\Domain\MedicalHistory\DTOs\MedicalHistoryDTO;
use App\Domain\MedicalHistory\Entities\MedicalHistory as MedicalHistoryEntity;
use App\Domain\MedicalHistory\Repositories\MedicalHistoryRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\Models\MedicalHistory as MedicalHistoryModel;
use DateTimeImmutable;

final class EloquentMedicalHistoryRepository implements MedicalHistoryRepositoryInterface
{
    public function findById(int $id): ?MedicalHistoryEntity
    {
        $model = MedicalHistoryModel::find($id);
        return $model ? $this->toEntity($model) : null;
    }

    public function findAll(int $page = 1, int $perPage = 20): array
    {
        $paginator = MedicalHistoryModel::query()
            ->orderBy('date', 'desc')
            ->paginate($perPage, ['*'], 'page', $page);

        return [
            'items'    => array_map([$this, 'toEntity'], $paginator->items()),
            'total'    => $paginator->total(),
            'page'     => $paginator->currentPage(),
            'per_page' => $paginator->perPage(),
        ];
    }

    public function findByPatient(int $patientId): array
    {
        return MedicalHistoryModel::where('patient_id', $patientId)
            ->orderBy('date', 'desc')
            ->get()
            ->map([$this, 'toEntity'])
            ->all();
    }

    public function save(MedicalHistoryEntity $medicalHistory): MedicalHistoryEntity
    {
        $model = MedicalHistoryModel::create([
            'patient_id'  => $medicalHistory->patientId,
            'vet_id'      => $medicalHistory->vetId,
            'date'        => $medicalHistory->date->format('Y-m-d'),
            'type'        => $medicalHistory->type,
            'diagnosis'   => $medicalHistory->diagnosis,
            'treatment'   => $medicalHistory->treatment,
            'notes'       => $medicalHistory->notes,
            'weight'      => $medicalHistory->weight,
            'temperature' => $medicalHistory->temperature,
        ]);

        return $this->toEntity($model);
    }

    public function update(int $id, MedicalHistoryDTO $dto): MedicalHistoryEntity
    {
        $model = MedicalHistoryModel::findOrFail($id);
        $model->update([
            'patient_id'  => $dto->patientId,
            'vet_id'      => $dto->vetId,
            'date'        => $dto->date,
            'type'        => $dto->type,
            'diagnosis'   => $dto->diagnosis,
            'treatment'   => $dto->treatment,
            'notes'       => $dto->notes,
            'weight'      => $dto->weight,
            'temperature' => $dto->temperature,
        ]);

        return $this->toEntity($model->fresh());
    }

    public function delete(int $id): void
    {
        MedicalHistoryModel::findOrFail($id)->delete();
    }

    private function toEntity(MedicalHistoryModel $model): MedicalHistoryEntity
    {
        return new MedicalHistoryEntity(
            id: $model->id,
            patientId: $model->patient_id,
            vetId: $model->vet_id,
            date: new DateTimeImmutable($model->date->toDateString()),
            type: $model->type,
            diagnosis: $model->diagnosis,
            treatment: $model->treatment,
            notes: $model->notes,
            weight: $model->weight,
            temperature: $model->temperature,
            createdAt: new DateTimeImmutable($model->created_at->toDateTimeString()),
        );
    }
}
