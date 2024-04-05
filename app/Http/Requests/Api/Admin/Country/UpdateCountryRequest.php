<?php

namespace App\Http\Requests\Api\Admin\Country;

use App\Rules\ValidateTranslationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCountryRequest extends FormRequest
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
                Rule::unique('admin_db.country_country_translations', 'content')
                    ->ignore($this->route('uuid'), 'country_uuid'),
            ],
            'iso' => [
                'required',
                'alpha',
                'max:3',
                Rule::unique('admin_db.country_countries', 'iso')
                    ->ignore($this->route()->parameter('id'), 'id'),
            ],
            'is_active' => ['required', 'boolean'],
        ];
    }
}
