<?php

declare(strict_types=1);

namespace App\Domain\FollowUp\Entities;

use DateTimeImmutable;

final class FollowUp
{
    public function __construct(
        public readonly ?int $id,
        public readonly int $patientId,
        public readonly int $ownerId,
        public readonly DateTimeImmutable $date,
        public readonly string $type,
        public readonly string $status,
        public readonly ?string $notes,
        public readonly DateTimeImmutable $createdAt,
    ) {}

    public static function create(
        int $patientId,
        int $ownerId,
        DateTimeImmutable $date,
        string $type,
        string $status = 'pendiente',
        ?string $notes = null,
    ): self {
        return new self(
            id: null,
            patientId: $patientId,
            ownerId: $ownerId,
            date: $date,
            type: $type,
            status: $status,
            notes: $notes,
            createdAt: new DateTimeImmutable(),
        );
    }
}
