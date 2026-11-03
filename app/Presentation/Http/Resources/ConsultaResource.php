<?php

declare(strict_types=1);

namespace App\Presentation\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConsultaResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'              => $this->id,
            'patient_id'      => $this->patient_id,
            'appointment_id'  => $this->appointment_id,
            'vet'             => $this->vet,
            'chief_complaint' => $this->chief_complaint,
            'diagnosis'       => $this->diagnosis,
            'base_fee'        => (float) $this->base_fee,
            'status'          => $this->status,
            'opened_at'       => $this->opened_at?->toIso8601String(),
            'closed_at'       => $this->closed_at?->toIso8601String(),
        ];
    }
}
