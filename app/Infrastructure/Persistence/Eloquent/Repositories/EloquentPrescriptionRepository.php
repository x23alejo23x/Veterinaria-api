<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Repositories;

use App\Domain\Prescription\DTOs\PrescriptionDTO;
use App\Domain\Prescription\Entities\Prescription as PrescriptionEntity;
use App\Domain\Prescription\Repositories\PrescriptionRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\Models\Prescription as PrescriptionModel;
use DateTimeImmutable;

final class EloquentPrescriptionRepository implements PrescriptionRepositoryInterface
{
    public function findById(int $id): ?PrescriptionEntity
    {
        $m = PrescriptionModel::find($id);
        return $m ? $this->toEntity($m) : null;
    }

    public function findAll(int $page = 1, int $perPage = 20, ?int $patientId = null, ?int $medicationId = null): array
    {
        $q = PrescriptionModel::query();
        if ($patientId)    $q->where('patient_id', $patientId);
        if ($medicationId) $q->where('medication_id', $medicationId);
        $paginator = $q->orderBy('date', 'desc')->paginate($perPage, ['*'], 'page', $page);

        return [
            'items'    => array_map([$this, 'toEntity'], $paginator->items()),
            'total'    => $paginator->total(),
            'page'     => $paginator->currentPage(),
            'per_page' => $paginator->perPage(),
        ];
    }

    public function save(PrescriptionEntity $p): PrescriptionEntity
    {
        $m = PrescriptionModel::create([
            'patient_id'    => $p->patientId,
            'medication_id' => $p->medicationId,
            'dose'          => $p->dose,
            'frequency'     => $p->frequency,
            'duration'      => $p->duration,
            'notes'         => $p->notes,
            'status'        => $p->status,
            'vet'           => $p->vet,
            'date'          => $p->date,
        ]);
        return $this->toEntity($m);
    }

    public function update(int $id, PrescriptionDTO $dto): PrescriptionEntity
    {
        $m = PrescriptionModel::findOrFail($id);
        $m->update([
            'patient_id'    => $dto->patientId,
            'medication_id' => $dto->medicationId,
            'dose'          => $dto->dose,
            'frequency'     => $dto->frequency,
            'duration'      => $dto->duration,
            'notes'         => $dto->notes,
            'status'        => $dto->status,
            'vet'           => $dto->vet,
            'date'          => $dto->date,
        ]);
        return $this->toEntity($m->fresh());
    }

    public function delete(int $id): void
    {
        PrescriptionModel::findOrFail($id)->delete();
    }

    private function toEntity(PrescriptionModel $m): PrescriptionEntity
    {
        return new PrescriptionEntity(
            id: $m->id,
            patientId: $m->patient_id,
            medicationId: $m->medication_id,
            dose: $m->dose,
            frequency: $m->frequency,
            duration: $m->duration,
            notes: $m->notes,
            status: $m->status,
            vet: $m->vet,
            date: $m->date?->format('Y-m-d') ?? '',
            createdAt: new DateTimeImmutable($m->created_at->toDateTimeString()),
        );
    }
}
