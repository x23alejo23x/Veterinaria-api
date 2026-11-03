<?php

declare(strict_types=1);

namespace App\Presentation\Http\Requests\Owner;

use Illuminate\Foundation\Http\FormRequest;

final class StoreOwnerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'  => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'unique:owners,email'],
            'phone' => ['required', 'string', 'max:20'],
            'city'  => ['required', 'string', 'max:80'],
        ];
    }
}
