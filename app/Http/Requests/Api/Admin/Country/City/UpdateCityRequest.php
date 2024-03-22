<?php

namespace App\Http\Requests\Api\Admin\Country\City;

use App\Rules\ValidateTranslationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCityRequest extends FormRequest
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
                'max:255',
                Rule::exists('admin_db.company_companies', 'uuid'),
            ],
            'country_uuid' => [
                'required',
                'string',
                'max:255',
                Rule::exists('admin_db.university_countries', 'uuid'),
            ],
            'translations' => [
                new ValidateTranslationRule(['value']),
            ],
        ];
    }
}
