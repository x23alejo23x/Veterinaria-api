<?php

declare(strict_types=1);

namespace App\Presentation\Http\Requests\Patient;

use Illuminate\Foundation\Http\FormRequest;

final class StorePatientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'         => ['required', 'string', 'max:100'],
            'species'      => ['required', 'string', 'max:50'],
            'breed'        => ['required', 'string', 'max:100'],
            'age'          => ['required', 'integer', 'min:0'],
            'weight'       => ['required', 'numeric', 'min:0'],
            'owner_id'     => ['required', 'integer', 'exists:owners,id'],
            'status'       => ['nullable', 'string', 'in:activo,inactivo,critico'],
            'avatar_color' => ['nullable', 'string', 'max:30'],
            'next_visit'   => ['nullable', 'date'],
        ];
    }
}
