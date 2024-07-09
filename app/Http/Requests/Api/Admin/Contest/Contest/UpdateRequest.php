<?php

namespace App\Http\Requests\Api\Admin\Contest\Contest;

use App\Rules\ValidateTranslationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'participants_number' => [
                'required',
                'numeric',
            ],
            'translations' => [
                'required',
                new ValidateTranslationRule(['title', 'description']),
            ],
            'application_status_uuids' => [
                'array',
            ],
            'application_status_uuids.*' => [
                'uuid',
                Rule::exists('admin_db.university_application_status_values', 'uuid')
            ],
            'student_nationality_uuids' => [
                'array',
            ],
            'student_nationality_uuids.*' => [
                'uuid',
                Rule::exists('admin_db.country_countries', 'uuid')
            ],
            'start_time' => [
                'required',
                'date',
            ],
            'is_active' => [
                'required',
                'boolean',
            ],
            'end_time' => [
                'nullable',
                'date',
            ],
        ];
    }
}
