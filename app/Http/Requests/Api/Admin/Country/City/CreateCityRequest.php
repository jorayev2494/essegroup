<?php

namespace App\Http\Requests\Api\Admin\Country\City;

use App\Rules\ValidateTranslationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateCityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'country_uuid' => [
                'required',
                'string',
                'max:255',
                Rule::exists('admin_db.country_countries', 'uuid'),
            ],
            'translations' => [
                'required',
                new ValidateTranslationRule(['value']),
            ],
            'translations.*.value' => [
                Rule::unique('admin_db.country_city_translations', 'content'),
            ],
        ];
    }
}
