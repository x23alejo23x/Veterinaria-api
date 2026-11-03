<?php

declare(strict_types=1);

namespace App\Domain\Owner\DTOs;

final class OwnerDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $phone,
        public readonly string $city,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            email: $data['email'],
            phone: $data['phone'],
            city: $data['city'],
        );
    }
}
