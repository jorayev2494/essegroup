<?php

namespace App\Http\Requests\Api\Admin\University\Department;

use App\Rules\ValidateTranslationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DepartmentStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name_uuid' => [
                'required',
                'string',
                Rule::exists('admin_db.university_department_names', 'uuid'),
            ],
            'alias_uuid' => [
                'required',
                'string',
                Rule::exists('admin_db.university_aliases', 'uuid'),
            ],
            'university_uuid' => [
                'required',
                'string',
                Rule::exists('admin_db.university_universities', 'uuid'),
            ],
            'faculty_uuid' => [
                'required',
                'string',
                Rule::exists('admin_db.faculty_faculties', 'uuid'),
            ],
            'degree_uuid' => [
                'required',
                'string',
                Rule::exists('admin_db.university_degrees', 'uuid'),
            ],
            'degree_uuids.*' => [
                'required',
                'string',
                Rule::exists('admin_db.university_degrees', 'uuid'),
            ],
            'translations' => [
                'required',
                new ValidateTranslationRule(['description']),
            ],
            'language_uuid' => [
                'required',
                'string',
                Rule::exists('admin_db.language_languages', 'uuid'),
            ],
            'price' => [
                'required',
                'numeric',
            ],
            'price_currency_uuid' => [
                'required',
                'uuid',
                Rule::exists('admin_db.currency_currencies', 'uuid'),
            ],
            'is_filled' => [
                'required',
                'boolean',
            ],
            'discount_price' => [
                'nullable',
                'numeric',
                'lt:price',
            ],
        ];
    }
}
