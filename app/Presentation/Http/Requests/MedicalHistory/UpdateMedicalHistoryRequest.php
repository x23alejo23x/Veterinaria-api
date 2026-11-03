<?php

declare(strict_types=1);

namespace App\Presentation\Http\Requests\MedicalHistory;

use Illuminate\Foundation\Http\FormRequest;

final class UpdateMedicalHistoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'patient_id'  => ['sometimes', 'required', 'integer', 'exists:patients,id'],
            'vet_id'      => ['sometimes', 'nullable', 'integer'],
            'date'        => ['sometimes', 'required', 'date'],
            'type'        => ['sometimes', 'required', 'string', 'max:80'],
            'diagnosis'   => ['sometimes', 'required', 'string'],
            'treatment'   => ['sometimes', 'required', 'string'],
            'notes'       => ['sometimes', 'nullable', 'string'],
            'weight'      => ['sometimes', 'nullable', 'numeric'],
            'temperature' => ['sometimes', 'nullable', 'numeric'],
        ];
    }
}
