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
                Rule::unique('pgsql_admin.country_countries', 'value')
                    ->where('company_uuid', AuthManager::getCompanyUuid())
            ],
            'iso' => [
                'required',
                'alpha',
                'max:3',
                Rule::unique('pgsql_admin.country_countries', 'iso')
                    ->where('company_uuid', AuthManager::getCompanyUuid())
            ],
            'is_active' => ['required', 'boolean'],
        ];
    }
}
