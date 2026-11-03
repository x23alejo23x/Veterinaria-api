<?php

declare(strict_types=1);

namespace App\Domain\Appointment\Entities;

use DateTimeImmutable;

final class Appointment
{
    public function __construct(
        public readonly ?int $id,
        public readonly int $patientId,
        public readonly int $ownerId,
        public readonly ?int $vetId,
        public readonly DateTimeImmutable $date,
        public readonly string $time,
        public readonly string $type,
        public readonly string $status,
        public readonly ?string $notes,
        public readonly DateTimeImmutable $createdAt,
    ) {}

    public static function create(
        int $patientId,
        int $ownerId,
        DateTimeImmutable $date,
        string $time,
        string $type,
        string $status = 'pendiente',
        ?int $vetId = null,
        ?string $notes = null,
    ): self {
        return new self(
            id: null,
            patientId: $patientId,
            ownerId: $ownerId,
            vetId: $vetId,
            date: $date,
            time: $time,
            type: $type,
            status: $status,
            notes: $notes,
            createdAt: new DateTimeImmutable(),
        );
    }
}
