<?php

declare(strict_types=1);

namespace App\Domain\MedicalHistory\Entities;

use DateTimeImmutable;

final class MedicalHistory
{
    public function __construct(
        public readonly ?int $id,
        public readonly int $patientId,
        public readonly ?int $vetId,
        public readonly DateTimeImmutable $date,
        public readonly string $type,
        public readonly string $diagnosis,
        public readonly string $treatment,
        public readonly ?string $notes,
        public readonly ?float $weight,
        public readonly ?float $temperature,
        public readonly DateTimeImmutable $createdAt,
    ) {}

    public static function create(
        int $patientId,
        DateTimeImmutable $date,
        string $type,
        string $diagnosis,
        string $treatment,
        ?int $vetId = null,
        ?string $notes = null,
        ?float $weight = null,
        ?float $temperature = null,
    ): self {
        return new self(
            id: null,
            patientId: $patientId,
            vetId: $vetId,
            date: $date,
            type: $type,
            diagnosis: $diagnosis,
            treatment: $treatment,
            notes: $notes,
            weight: $weight,
            temperature: $temperature,
            createdAt: new DateTimeImmutable(),
        );
    }
}
