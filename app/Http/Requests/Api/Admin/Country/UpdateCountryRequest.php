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
            'value' => [
                'required',
                'alpha',
                'max:255',
                Rule::unique('admin_db.country_countries', 'value')
                    ->ignore($this->route()->parameter('id'), 'id'),
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
