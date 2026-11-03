<?php

declare(strict_types=1);

namespace App\Domain\Prescription\Entities;

use DateTimeImmutable;

final class Prescription
{
    public function __construct(
        public readonly ?int $id,
        public readonly int $patientId,
        public readonly int $medicationId,
        public readonly string $dose,
        public readonly string $frequency,
        public readonly string $duration,
        public readonly ?string $notes,
        public readonly string $status,
        public readonly ?string $vet,
        public readonly string $date,
        public readonly DateTimeImmutable $createdAt,
    ) {}

    public static function create(
        int $patientId,
        int $medicationId,
        string $dose,
        string $frequency,
        string $duration,
        ?string $notes = null,
        string $status = 'Activa',
        ?string $vet = null,
        ?string $date = null,
    ): self {
        return new self(
            id: null,
            patientId: $patientId,
            medicationId: $medicationId,
            dose: $dose,
            frequency: $frequency,
            duration: $duration,
            notes: $notes,
            status: $status,
            vet: $vet,
            date: $date ?? date('Y-m-d'),
            createdAt: new DateTimeImmutable(),
        );
    }
}
