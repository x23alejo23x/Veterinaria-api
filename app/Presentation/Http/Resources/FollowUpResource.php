<?php

declare(strict_types=1);

namespace App\Presentation\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

final class FollowUpResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'         => $this->resource->id,
            'patient_id' => $this->resource->patientId,
            'owner_id'   => $this->resource->ownerId,
            'date'       => $this->resource->date?->format('Y-m-d'),
            'type'       => $this->resource->type,
            'status'     => $this->resource->status,
            'notes'      => $this->resource->notes,
            'created_at' => $this->resource->createdAt?->format('Y-m-d H:i:s'),
        ];
    }
}
