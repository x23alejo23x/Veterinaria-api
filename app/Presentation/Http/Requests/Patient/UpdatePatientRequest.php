<?php

declare(strict_types=1);

namespace App\Presentation\Http\Requests\Patient;

use Illuminate\Foundation\Http\FormRequest;

final class UpdatePatientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'         => ['sometimes', 'required', 'string', 'max:100'],
            'species'      => ['sometimes', 'required', 'string', 'max:50'],
            'breed'        => ['sometimes', 'required', 'string', 'max:100'],
            'age'          => ['sometimes', 'required', 'integer', 'min:0'],
            'weight'       => ['sometimes', 'required', 'numeric', 'min:0'],
            'owner_id'     => ['sometimes', 'required', 'integer', 'exists:owners,id'],
            'status'       => ['sometimes', 'nullable', 'string', 'in:activo,inactivo,critico'],
            'avatar_color' => ['sometimes', 'nullable', 'string', 'max:30'],
            'next_visit'   => ['sometimes', 'nullable', 'date'],
        ];
    }
}
