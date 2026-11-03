<?php

declare(strict_types=1);

namespace App\Presentation\Http\Requests\FollowUp;

use Illuminate\Foundation\Http\FormRequest;

final class UpdateFollowUpRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'patient_id' => ['sometimes', 'required', 'integer', 'exists:patients,id'],
            'owner_id'   => ['sometimes', 'required', 'integer', 'exists:owners,id'],
            'date'       => ['sometimes', 'required', 'date'],
            'type'       => ['sometimes', 'required', 'string', 'max:80'],
            'status'     => ['sometimes', 'nullable', 'string', 'in:pendiente,completado,cancelado'],
            'notes'      => ['sometimes', 'nullable', 'string'],
        ];
    }
}
