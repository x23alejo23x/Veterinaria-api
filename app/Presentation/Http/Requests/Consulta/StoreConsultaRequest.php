<?php

declare(strict_types=1);

namespace App\Presentation\Http\Requests\Consulta;

use Illuminate\Foundation\Http\FormRequest;

class StoreConsultaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'patient_id'      => ['required', 'integer', 'exists:patients,id'],
            'vet'             => ['required', 'string', 'max:200'],
            'appointment_id'  => ['nullable', 'integer', 'exists:appointments,id'],
            'chief_complaint' => ['nullable', 'string', 'max:500'],
            'diagnosis'       => ['nullable', 'string'],
            'base_fee'        => ['nullable', 'numeric', 'min:0'],
        ];
    }
}
