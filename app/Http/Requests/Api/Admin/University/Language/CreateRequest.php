<?php

namespace App\Http\Requests\Api\Admin\University\Language;

use App\Rules\ValidateTranslationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'translations' => [
                'required',
                new ValidateTranslationRule(['value']),
            ],
            'translations.*.value' => [
                Rule::unique('admin_db.language_language_translations', 'content'),
            ],
        ];
    }
}
