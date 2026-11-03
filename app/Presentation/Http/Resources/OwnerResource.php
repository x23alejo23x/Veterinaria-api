<?php

declare(strict_types=1);

namespace App\Presentation\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

final class OwnerResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'         => $this->resource->id,
            'name'       => $this->resource->name,
            'email'      => $this->resource->email,
            'phone'      => $this->resource->phone,
            'city'       => $this->resource->city,
            'created_at' => $this->resource->createdAt?->format('Y-m-d H:i:s'),
        ];
    }
}
