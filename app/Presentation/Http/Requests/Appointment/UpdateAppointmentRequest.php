<?php

declare(strict_types=1);

namespace App\Presentation\Http\Requests\Appointment;

use Illuminate\Foundation\Http\FormRequest;

final class UpdateAppointmentRequest extends FormRequest
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
            'vet_id'     => ['sometimes', 'nullable', 'integer', 'exists:users,id'],
            'date'       => ['sometimes', 'required', 'date'],
            'time'       => ['sometimes', 'required', 'string'],
            'type'       => ['sometimes', 'required', 'string', 'max:80'],
            'status'     => ['sometimes', 'nullable', 'string', 'in:pendiente,confirmada,cancelada,completada'],
            'notes'      => ['sometimes', 'nullable', 'string'],
        ];
    }
}
