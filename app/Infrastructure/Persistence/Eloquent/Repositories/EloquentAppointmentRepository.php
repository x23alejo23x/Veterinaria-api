<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Repositories;

use App\Domain\Appointment\DTOs\AppointmentDTO;
use App\Domain\Appointment\Entities\Appointment as AppointmentEntity;
use App\Domain\Appointment\Repositories\AppointmentRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\Models\Appointment as AppointmentModel;
use DateTimeImmutable;

final class EloquentAppointmentRepository implements AppointmentRepositoryInterface
{
    public function findById(int $id): ?AppointmentEntity
    {
        $model = AppointmentModel::find($id);
        return $model ? $this->toEntity($model) : null;
    }

    public function findAll(int $page = 1, int $perPage = 20, ?string $status = null): array
    {
        $query = AppointmentModel::query();

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
        return AppointmentModel::where('patient_id', $patientId)
            ->orderBy('date', 'desc')
            ->get()
            ->map([$this, 'toEntity'])
            ->all();
    }

    public function save(AppointmentEntity $appointment): AppointmentEntity
    {
        $model = AppointmentModel::create([
            'patient_id' => $appointment->patientId,
            'owner_id'   => $appointment->ownerId,
            'vet_id'     => $appointment->vetId,
            'date'       => $appointment->date->format('Y-m-d'),
            'time'       => $appointment->time,
            'type'       => $appointment->type,
            'status'     => $appointment->status,
            'notes'      => $appointment->notes,
        ]);

        return $this->toEntity($model);
    }

    public function update(int $id, AppointmentDTO $dto): AppointmentEntity
    {
        $model = AppointmentModel::findOrFail($id);
        $model->update([
            'patient_id' => $dto->patientId,
            'owner_id'   => $dto->ownerId,
            'vet_id'     => $dto->vetId,
            'date'       => $dto->date,
            'time'       => $dto->time,
            'type'       => $dto->type,
            'status'     => $dto->status,
            'notes'      => $dto->notes,
        ]);

        return $this->toEntity($model->fresh());
    }

    public function delete(int $id): void
    {
        AppointmentModel::findOrFail($id)->delete();
    }

    private function toEntity(AppointmentModel $model): AppointmentEntity
    {
        return new AppointmentEntity(
            id: $model->id,
            patientId: $model->patient_id,
            ownerId: $model->owner_id,
            vetId: $model->vet_id,
            date: new DateTimeImmutable($model->date->toDateString()),
            time: $model->time,
            type: $model->type,
            status: $model->status,
            notes: $model->notes,
            createdAt: new DateTimeImmutable($model->created_at->toDateTimeString()),
        );
    }
}
