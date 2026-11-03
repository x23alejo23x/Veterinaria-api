<?php

declare(strict_types=1);

namespace App\Domain\Medication\Entities;

use DateTimeImmutable;

final class Medication
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $name,
        public readonly string $category,
        public readonly int $stock,
        public readonly string $unit,
        public readonly float $price,
        public readonly string $supplier,
        public readonly ?DateTimeImmutable $expiryDate,
        public readonly string $status,
        public readonly DateTimeImmutable $createdAt,
    ) {}

    public static function create(
        string $name,
        string $category,
        int $stock,
        string $unit,
        float $price,
        string $supplier,
        ?DateTimeImmutable $expiryDate = null,
        string $status = 'disponible',
    ): self {
        return new self(
            id: null,
            name: $name,
            category: $category,
            stock: $stock,
            unit: $unit,
            price: $price,
            supplier: $supplier,
            expiryDate: $expiryDate,
            status: $status,
            createdAt: new DateTimeImmutable(),
        );
    }
}
