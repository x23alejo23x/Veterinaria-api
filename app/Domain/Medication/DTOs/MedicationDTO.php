<?php

declare(strict_types=1);

namespace App\Domain\Medication\DTOs;

final class MedicationDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $category,
        public readonly int $stock,
        public readonly string $unit,
        public readonly float $price,
        public readonly string $supplier,
        public readonly ?string $expiryDate = null,
        public readonly string $status = 'disponible',
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            category: $data['category'],
            stock: (int) $data['stock'],
            unit: $data['unit'],
            price: (float) $data['price'],
            supplier: $data['supplier'],
            expiryDate: $data['expiry_date'] ?? null,
            status: $data['status'] ?? 'disponible',
        );
    }
}
