<?php

declare(strict_types=1);

namespace App\Presentation\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

final class PrescriptionResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'            => $this->resource->id,
            'patient_id'    => $this->resource->patientId,
            'medication_id' => $this->resource->medicationId,
            'dose'          => $this->resource->dose,
            'frequency'     => $this->resource->frequency,
            'duration'      => $this->resource->duration,
            'notes'         => $this->resource->notes,
            'status'        => $this->resource->status,
            'vet'           => $this->resource->vet,
            'date'          => $this->resource->date,
            'created_at'    => $this->resource->createdAt->format('Y-m-d H:i:s'),
        ];
    }
}
