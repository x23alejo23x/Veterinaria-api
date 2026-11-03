<?php

declare(strict_types=1);

namespace App\Domain\Patient\DTOs;

final class PatientDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $species,
        public readonly string $breed,
        public readonly int $age,
        public readonly float $weight,
        public readonly int $ownerId,
        public readonly string $status = 'activo',
        public readonly string $avatarColor = 'blue',
        public readonly ?string $nextVisit = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            species: $data['species'],
            breed: $data['breed'],
            age: (int) $data['age'],
            weight: (float) $data['weight'],
            ownerId: (int) $data['owner_id'],
            status: $data['status'] ?? 'activo',
            avatarColor: $data['avatar_color'] ?? 'blue',
            nextVisit: $data['next_visit'] ?? null,
        );
    }
}
