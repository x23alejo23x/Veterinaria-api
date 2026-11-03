<?php

declare(strict_types=1);

namespace App\Presentation\Http\Requests\Appointment;

use Illuminate\Foundation\Http\FormRequest;

final class StoreAppointmentRequest extends FormRequest
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
            'vet_id'     => ['nullable', 'integer', 'exists:users,id'],
            'date'       => ['required', 'date'],
            'time'       => ['required', 'string'],
            'type'       => ['required', 'string', 'max:80'],
            'status'     => ['nullable', 'string', 'in:pendiente,confirmada,cancelada,completada'],
            'notes'      => ['nullable', 'string'],
        ];
    }
}
