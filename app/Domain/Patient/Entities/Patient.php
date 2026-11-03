<?php

declare(strict_types=1);

namespace App\Domain\Patient\Entities;

use DateTimeImmutable;

final class Patient
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $name,
        public readonly string $species,
        public readonly string $breed,
        public readonly int $age,
        public readonly float $weight,
        public readonly int $ownerId,
        public readonly string $status,
        public readonly string $avatarColor,
        public readonly ?DateTimeImmutable $nextVisit,
        public readonly DateTimeImmutable $createdAt,
    ) {}

    public static function create(
        string $name,
        string $species,
        string $breed,
        int $age,
        float $weight,
        int $ownerId,
        string $status = 'activo',
        string $avatarColor = 'blue',
        ?DateTimeImmutable $nextVisit = null,
    ): self {
        return new self(
            id: null,
            name: $name,
            species: $species,
            breed: $breed,
            age: $age,
            weight: $weight,
            ownerId: $ownerId,
            status: $status,
            avatarColor: $avatarColor,
            nextVisit: $nextVisit,
            createdAt: new DateTimeImmutable(),
        );
    }
}
