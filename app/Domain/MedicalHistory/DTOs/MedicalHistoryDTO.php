<?php

declare(strict_types=1);

namespace App\Domain\MedicalHistory\DTOs;

final class MedicalHistoryDTO
{
    public function __construct(
        public readonly int $patientId,
        public readonly string $date,
        public readonly string $type,
        public readonly string $diagnosis,
        public readonly string $treatment,
        public readonly ?int $vetId = null,
        public readonly ?string $notes = null,
        public readonly ?float $weight = null,
        public readonly ?float $temperature = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            patientId: (int) $data['patient_id'],
            date: $data['date'],
            type: $data['type'],
            diagnosis: $data['diagnosis'],
            treatment: $data['treatment'],
            vetId: isset($data['vet_id']) ? (int) $data['vet_id'] : null,
            notes: $data['notes'] ?? null,
            weight: isset($data['weight']) ? (float) $data['weight'] : null,
            temperature: isset($data['temperature']) ? (float) $data['temperature'] : null,
        );
    }
}
