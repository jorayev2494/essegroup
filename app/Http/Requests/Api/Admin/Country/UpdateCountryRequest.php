<?php

namespace App\Http\Requests\Api\Admin\Country;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Project\Infrastructure\Services\Auth\AuthManager;

class UpdateCountryRequest extends FormRequest
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
                Rule::exists('admin_db.company_companies', 'uuid'),
            ],
            'value' => [
                'required',
                'alpha',
                'max:255',
                Rule::unique('admin_db.country_countries', 'value')
                    ->where('company_uuid', AuthManager::getCompanyUuid())
                    ->ignore($this->route()->parameter('id'), 'id'),
            ],
            'iso' => [
                'required',
                'alpha',
                'max:3',
                Rule::unique('admin_db.country_countries', 'iso')
                    ->where('company_uuid', AuthManager::getCompanyUuid())
                    ->ignore($this->route()->parameter('id'), 'id'),
            ],
            'is_active' => ['required', 'boolean'],
        ];
    }
}
