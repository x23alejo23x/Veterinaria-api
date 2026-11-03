<?php

declare(strict_types=1);

namespace App\Presentation\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

final class MedicationResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'          => $this->resource->id,
            'name'        => $this->resource->name,
            'category'    => $this->resource->category,
            'stock'       => $this->resource->stock,
            'unit'        => $this->resource->unit,
            'price'       => $this->resource->price,
            'supplier'    => $this->resource->supplier,
            'expiry_date' => $this->resource->expiryDate?->format('Y-m-d'),
            'status'      => $this->resource->status,
            'created_at'  => $this->resource->createdAt?->format('Y-m-d H:i:s'),
        ];
    }
}
