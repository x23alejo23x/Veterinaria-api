<?php

declare(strict_types=1);

namespace App\Presentation\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

final class MedicalHistoryResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'          => $this->resource->id,
            'patient_id'  => $this->resource->patientId,
            'vet_id'      => $this->resource->vetId,
            'date'        => $this->resource->date?->format('Y-m-d'),
            'type'        => $this->resource->type,
            'diagnosis'   => $this->resource->diagnosis,
            'treatment'   => $this->resource->treatment,
            'notes'       => $this->resource->notes,
            'weight'      => $this->resource->weight,
            'temperature' => $this->resource->temperature,
            'created_at'  => $this->resource->createdAt?->format('Y-m-d H:i:s'),
        ];
    }
}
