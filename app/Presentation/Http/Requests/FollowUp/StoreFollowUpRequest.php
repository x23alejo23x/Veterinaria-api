<?php

declare(strict_types=1);

namespace App\Presentation\Http\Requests\FollowUp;

use Illuminate\Foundation\Http\FormRequest;

final class StoreFollowUpRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'patient_id' => ['required', 'integer', 'exists:patients,id'],
            'owner_id'   => ['required', 'integer', 'exists:owners,id'],
            'date'       => ['required', 'date'],
            'type'       => ['required', 'string', 'max:80'],
            'status'     => ['nullable', 'string', 'in:pendiente,completado,cancelado'],
            'notes'      => ['nullable', 'string'],
        ];
    }
}
