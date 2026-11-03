<?php

declare(strict_types=1);

namespace App\Presentation\Http\Requests\MedicalHistory;

use Illuminate\Foundation\Http\FormRequest;

final class StoreMedicalHistoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'patient_id'  => ['required', 'integer', 'exists:patients,id'],
            'vet_id'      => ['nullable', 'integer'],
            'date'        => ['required', 'date'],
            'type'        => ['required', 'string', 'max:80'],
            'diagnosis'   => ['required', 'string'],
            'treatment'   => ['required', 'string'],
            'notes'       => ['nullable', 'string'],
            'weight'      => ['nullable', 'numeric'],
            'temperature' => ['nullable', 'numeric'],
        ];
    }
}
