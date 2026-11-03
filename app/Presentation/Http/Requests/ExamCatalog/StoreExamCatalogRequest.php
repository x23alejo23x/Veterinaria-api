<?php

declare(strict_types=1);

namespace App\Presentation\Http\Requests\ExamCatalog;

use Illuminate\Foundation\Http\FormRequest;

class StoreExamCatalogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'     => ['required', 'string', 'max:120'],
            'category' => ['required', 'string', 'max:60'],
            'price'    => ['required', 'numeric', 'min:0'],
        ];
    }
}
