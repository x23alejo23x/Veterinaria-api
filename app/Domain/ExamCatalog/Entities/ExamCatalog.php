<?php

declare(strict_types=1);

namespace App\Domain\ExamCatalog\Entities;

use DateTimeImmutable;

final class ExamCatalog
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $name,
        public readonly string $category,
        public readonly float $price,
        public readonly ?DateTimeImmutable $createdAt,
    ) {}

    public static function create(
        string $name,
        string $category = 'Otro',
        float $price = 0.0,
    ): self {
        return new self(
            id: null,
            name: $name,
            category: $category,
            price: $price,
            createdAt: new DateTimeImmutable(),
        );
    }
}
