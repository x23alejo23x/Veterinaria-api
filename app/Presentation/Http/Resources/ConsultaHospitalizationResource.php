<?php

declare(strict_types=1);

namespace App\Presentation\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConsultaHospitalizationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'consulta_id'   => $this->consulta_id,
            'days'          => $this->days,
            'price_per_day' => (float) $this->price_per_day,
            'notes'         => $this->notes,
        ];
    }
}
