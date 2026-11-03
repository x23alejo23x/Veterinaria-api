<?php

declare(strict_types=1);

namespace App\Domain\Prescription\DTOs;

final class PrescriptionDTO
{
    public function __construct(
        public readonly int $patientId,
        public readonly int $medicationId,
        public readonly string $dose,
        public readonly string $frequency,
        public readonly string $duration,
        public readonly ?string $notes = null,
        public readonly string $status = 'Activa',
        public readonly ?string $vet = null,
        public readonly ?string $date = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            patientId: (int) $data['patient_id'],
            medicationId: (int) $data['medication_id'],
            dose: $data['dose'],
            frequency: $data['frequency'],
            duration: $data['duration'],
            notes: $data['notes'] ?? null,
            status: $data['status'] ?? 'Activa',
            vet: $data['vet'] ?? null,
            date: $data['date'] ?? null,
        );
    }
}
