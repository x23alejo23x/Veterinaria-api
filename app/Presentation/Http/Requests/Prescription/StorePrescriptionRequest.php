<?php

declare(strict_types=1);

namespace App\Presentation\Http\Requests\Prescription;

use Illuminate\Foundation\Http\FormRequest;

final class StorePrescriptionRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'patient_id'    => 'required|integer|exists:patients,id',
            'medication_id' => 'required|integer|exists:medications,id',
            'dose'          => 'required|string|max:50',
            'frequency'     => 'required|string|max:80',
            'duration'      => 'required|string|max:80',
            'notes'         => 'nullable|string',
            'status'        => 'nullable|string|in:Activa,Finalizada,Suspendida',
            'vet'           => 'nullable|string|max:100',
            'date'          => 'nullable|date',
        ];
    }
}
