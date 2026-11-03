<?php

declare(strict_types=1);

namespace App\Domain\Appointment\DTOs;

final class AppointmentDTO
{
    public function __construct(
        public readonly int $patientId,
        public readonly int $ownerId,
        public readonly string $date,
        public readonly string $time,
        public readonly string $type,
        public readonly string $status = 'pendiente',
        public readonly ?int $vetId = null,
        public readonly ?string $notes = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            patientId: (int) $data['patient_id'],
            ownerId: (int) $data['owner_id'],
            date: $data['date'],
            time: $data['time'],
            type: $data['type'],
            status: $data['status'] ?? 'pendiente',
            vetId: isset($data['vet_id']) ? (int) $data['vet_id'] : null,
            notes: $data['notes'] ?? null,
        );
    }
}
