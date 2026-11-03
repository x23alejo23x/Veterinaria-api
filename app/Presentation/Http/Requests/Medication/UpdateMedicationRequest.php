<?php

declare(strict_types=1);

namespace App\Presentation\Http\Requests\Medication;

use Illuminate\Foundation\Http\FormRequest;

final class UpdateMedicationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'        => ['sometimes', 'required', 'string', 'max:100'],
            'category'    => ['sometimes', 'required', 'string', 'max:60'],
            'stock'       => ['sometimes', 'required', 'integer', 'min:0'],
            'unit'        => ['sometimes', 'required', 'string', 'max:20'],
            'price'       => ['sometimes', 'required', 'numeric', 'min:0'],
            'supplier'    => ['sometimes', 'required', 'string', 'max:100'],
            'expiry_date' => ['sometimes', 'nullable', 'date'],
            'status'      => ['sometimes', 'nullable', 'string', 'in:disponible,agotado,vencido'],
        ];
    }
}
