<?php

declare(strict_types=1);

namespace App\Presentation\Http\Requests\Medication;

use Illuminate\Foundation\Http\FormRequest;

final class StoreMedicationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'        => ['required', 'string', 'max:100'],
            'category'    => ['required', 'string', 'max:60'],
            'stock'       => ['required', 'integer', 'min:0'],
            'unit'        => ['required', 'string', 'max:20'],
            'price'       => ['required', 'numeric', 'min:0'],
            'supplier'    => ['required', 'string', 'max:100'],
            'expiry_date' => ['nullable', 'date'],
            'status'      => ['nullable', 'string', 'in:disponible,agotado,vencido'],
        ];
    }
}
