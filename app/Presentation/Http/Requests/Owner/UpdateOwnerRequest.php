<?php

declare(strict_types=1);

namespace App\Presentation\Http\Requests\Owner;

use Illuminate\Foundation\Http\FormRequest;

final class UpdateOwnerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'  => ['sometimes', 'required', 'string', 'max:100'],
            'email' => ['sometimes', 'required', 'email', 'unique:owners,email'],
            'phone' => ['sometimes', 'required', 'string', 'max:20'],
            'city'  => ['sometimes', 'required', 'string', 'max:80'],
        ];
    }
}
