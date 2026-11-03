<?php

declare(strict_types=1);

namespace App\Presentation\Http\Requests\Consulta;

use Illuminate\Foundation\Http\FormRequest;

class UpdateConsultaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'vet'             => ['required', 'string', 'max:200'],
            'chief_complaint' => ['nullable', 'string', 'max:500'],
            'diagnosis'       => ['nullable', 'string'],
            'base_fee'        => ['nullable', 'numeric', 'min:0'],
        ];
    }
}
