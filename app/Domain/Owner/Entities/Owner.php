<?php

declare(strict_types=1);

namespace App\Domain\Owner\Entities;

use DateTimeImmutable;

final class Owner
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $name,
        public readonly string $email,
        public readonly string $phone,
        public readonly string $city,
        public readonly DateTimeImmutable $createdAt,
    ) {}

    public static function create(
        string $name,
        string $email,
        string $phone,
        string $city,
    ): self {
        return new self(
            id: null,
            name: $name,
            email: $email,
            phone: $phone,
            city: $city,
            createdAt: new DateTimeImmutable(),
        );
    }
}
