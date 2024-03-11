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
            'company_uuid' => [
                'required',
                'string',
                Rule::exists('admin_db.company_companies', 'uuid'),
            ],
            'faculty_uuid' => [
                'required',
                'string',
                Rule::exists('admin_db.faculty_faculties', 'uuid'),
            ],
            'translations' => ['required', 'array'],
            'translations.*.name' => ['required'],
            'translations.*.description' => ['required'],
//            'is_active' => [
//                'required',
//            ],
        ];
    }
}
