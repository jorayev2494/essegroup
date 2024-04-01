<?php

namespace App\Http\Requests\Api\Admin\University\Department;

use App\Rules\ValidateTranslationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DepartmentStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'degree_uuids' => [
                'required',
                'array',
            ],
            'degree_uuids.*' => [
                'required',
                'string',
                Rule::exists('admin_db.university_degrees', 'uuid'),
            ],
            'translations' => [
                'required',
                new ValidateTranslationRule(['name', 'description']),
            ],
            'is_filled' => [
                'required',
                'boolean',
            ],
        ];
    }
}
