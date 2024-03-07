<?php

namespace App\Http\Requests\Api\Company\Authentication\Restore;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RestorePasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'token' => ['required', 'string', Rule::exists('pgsql_admin.auth_codes', 'value')],
            'password' => ['required', 'string', 'confirmed'],
        ];
    }
}
