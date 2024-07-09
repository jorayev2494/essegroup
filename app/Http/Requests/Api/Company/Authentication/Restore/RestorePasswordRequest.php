<?php

namespace App\Http\Requests\Api\Company\Authentication\Restore;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Project\Domains\Admin\Company\Domain\Employee\ValueObjects\Password;

class RestorePasswordRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'token' => ['required', 'string', Rule::exists('admin_db.employee_auth_codes', 'value')],
            'password' => ['required', 'string', 'confirmed', 'min:' . Password::LENGTH],
        ];
    }
}
