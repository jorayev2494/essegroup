<?php

namespace App\Http\Requests\Api\Admin\University\Department\Name;

use App\Rules\ValidateTranslationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'translations' => [
                new ValidateTranslationRule(['value', 'description'], ['description' => ['nullable']]),
            ],
            'translations.*.value' => [
                Rule::unique('admin_db.university_department_name_translations', 'content'),
            ],
        ];
    }
}
