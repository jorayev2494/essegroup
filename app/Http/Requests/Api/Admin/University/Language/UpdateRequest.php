<?php

namespace App\Http\Requests\Api\Admin\University\Language;

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
            'iso' => [
                'required',
                'alpha',
                'max:3',
                Rule::unique('admin_db.language_languages', 'iso')
                    ->ignore($this->route()->parameter('uuid'), 'uuid'),
            ],
            'translations' => [
                'required',
                new ValidateTranslationRule(['value']),
            ],
            'translations.*.value' => [
                Rule::unique('admin_db.language_language_translations', 'content')
                    ->ignore($this->route('uuid'), 'language_uuid'),
            ],
        ];
    }
}
