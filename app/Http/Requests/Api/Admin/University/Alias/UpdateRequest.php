<?php

namespace App\Http\Requests\Api\Admin\University\Alias;

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
            'translations' => [
                'required',
                new ValidateTranslationRule(['value']),
            ],
            'translations.*.value' => [
                Rule::unique('admin_db.university_alias_translations', 'content')
                    ->ignore($this->route('uuid'), 'alias_uuid'),
            ],
        ];
    }
}
