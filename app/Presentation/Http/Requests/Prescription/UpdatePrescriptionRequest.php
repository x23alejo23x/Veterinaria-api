<?php

declare(strict_types=1);

namespace App\Presentation\Http\Requests\Prescription;

use Illuminate\Foundation\Http\FormRequest;

final class UpdatePrescriptionRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'patient_id'    => 'sometimes|integer|exists:patients,id',
            'medication_id' => 'sometimes|integer|exists:medications,id',
            'dose'          => 'sometimes|string|max:50',
            'frequency'     => 'sometimes|string|max:80',
            'duration'      => 'sometimes|string|max:80',
            'notes'         => 'nullable|string',
            'status'        => 'nullable|string|in:Activa,Finalizada,Suspendida',
            'vet'           => 'nullable|string|max:100',
            'date'          => 'nullable|date',
        ];
    }
}
