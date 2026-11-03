<?php

declare(strict_types=1);

namespace App\Presentation\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

final class PatientResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'           => $this->resource->id,
            'name'         => $this->resource->name,
            'species'      => $this->resource->species,
            'breed'        => $this->resource->breed,
            'age'          => $this->resource->age,
            'weight'       => $this->resource->weight,
            'owner_id'     => $this->resource->ownerId,
            'status'       => $this->resource->status,
            'avatar_color' => $this->resource->avatarColor,
            'next_visit'   => $this->resource->nextVisit?->format('Y-m-d'),
            'created_at'   => $this->resource->createdAt?->format('Y-m-d H:i:s'),
        ];
    }
}
