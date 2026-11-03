<?php

declare(strict_types=1);

namespace App\Domain\ExamCatalog\DTOs;

final class ExamCatalogDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $category = 'Otro',
        public readonly float $price = 0.0,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            category: $data['category'] ?? 'Otro',
            price: (float) ($data['price'] ?? 0),
        );
    }
}
