<?php

namespace App\Http\Requests\Api\Admin\University\Department;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DepartmentUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'degree_uuids.*' => [
                'required',
                'string',
                Rule::exists('admin_db.university_degrees', 'uuid'),
            ],
            'translations' => ['required', 'array'],
            'translations.*.name' => ['required'],
            'translations.*.description' => ['required'],
            'is_filled' => [
                'required',
                'boolean',
            ],
//            'is_active' => [
//                'required',
//            ],
        ];
    }
}
