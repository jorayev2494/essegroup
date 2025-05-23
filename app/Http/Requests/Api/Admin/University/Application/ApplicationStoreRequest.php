<?php

namespace App\Http\Requests\Api\Admin\University\Application;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ApplicationStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'student_uuid' => [
                'required',
                'uuid',
                Rule::exists('admin_db.student_students', 'uuid'),
            ],
            'alias_uuid' => [
                'required',
                'uuid',
                Rule::exists('admin_db.university_aliases', 'uuid'),
            ],
            'language_uuid' => [
                'required',
                'uuid',
                Rule::exists('admin_db.language_languages', 'uuid'),
            ],
            'degree_uuid' => [
                'required',
                'uuid',
                Rule::exists('admin_db.university_degrees', 'uuid'),
            ],
            'country_uuid' => [
                'required',
                'uuid',
                Rule::exists('admin_db.country_countries', 'uuid'),
            ],
            'university_uuid' => [
                'required',
                'uuid',
                Rule::exists('admin_db.university_universities', 'uuid'),
            ],
            'department_uuids' => [
                'required',
            ],
            'department_uuids.*' => [
                'uuid',
                Rule::exists('admin_db.university_departments', 'uuid'),
            ],

            // 'status_value_uuid' => [
            //     'required',
            //     'uuid',
            //     Rule::exists('admin_db.university_application_status_values', 'uuid'),
            // ],
        ];
    }
}
