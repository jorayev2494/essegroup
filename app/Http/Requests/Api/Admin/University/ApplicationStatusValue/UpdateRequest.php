<?php

namespace App\Http\Requests\Api\Admin\University\ApplicationStatusValue;

use App\Rules\ValidateTranslationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'text_color' => [
                'required',
                'max:10',
                'different:background_color',
            ],
            'background_color' => [
                'required',
                'max:10',
                'different:text_color'
            ],
            'translations' => [
                'required',
                new ValidateTranslationRule(['value', 'description']),
            ],
            'translations.*.value' => [
                'required',
                'max:20',
                Rule::unique('admin_db.university_application_status_value_translations', 'content')
                    ->where('field', 'value')
                    ->ignore($this->route('uuid'), 'status_value_uuid'),
            ],
            'translations.*.description' => [
                'required',
                Rule::unique('admin_db.university_application_status_value_translations', 'content')
                    ->where('field', 'description')
                    ->ignore($this->route('uuid'), 'status_value_uuid'),
            ],
            'is_required_note' => [
                'required',
                'boolean',
            ],
            'is_first' => [
                'required',
                'boolean',
                Rule::unique('admin_db.university_application_status_values', 'is_first')
                    ->where('is_first', true)
                    ->ignore($this->route('uuid'), 'uuid'),
            ],
        ];
    }
}
