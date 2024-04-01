<?php

namespace App\Http\Requests\Api\Admin\Country;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Project\Infrastructure\Services\Auth\AuthManager;

class CreateCountryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'value' => [
                'required',
                'alpha',
                'max:255',
                Rule::unique('admin_db.country_countries', 'value')
            ],
            'iso' => [
                'required',
                'alpha',
                'max:3',
                Rule::unique('admin_db.country_countries', 'iso')
            ],
            'is_active' => ['required', 'boolean'],
        ];
    }
}
