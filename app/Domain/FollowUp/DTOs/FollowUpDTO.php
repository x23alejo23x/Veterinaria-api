<?php

declare(strict_types=1);

namespace App\Domain\FollowUp\DTOs;

final class FollowUpDTO
{
    public function __construct(
        public readonly int $patientId,
        public readonly int $ownerId,
        public readonly string $date,
        public readonly string $type,
        public readonly string $status = 'pendiente',
        public readonly ?string $notes = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            patientId: (int) $data['patient_id'],
            ownerId: (int) $data['owner_id'],
            date: $data['date'],
            type: $data['type'],
            status: $data['status'] ?? 'pendiente',
            notes: $data['notes'] ?? null,
        );
    }
}
