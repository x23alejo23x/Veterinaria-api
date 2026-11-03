<?php

declare(strict_types=1);

namespace App\Presentation\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConsultaExamResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'consulta_id' => $this->consulta_id,
            'name'        => $this->name,
            'category'    => $this->category,
            'unit_price'  => (float) $this->unit_price,
            'notes'       => $this->notes,
        ];
    }
}
