<?php

namespace App\Http\Requests\Api\Admin\Authentication\Restore;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Project\Domains\Admin\Manager\Domain\Manager\ValueObjects\Password;

class RestorePasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'token' => ['required', 'string', Rule::exists('admin_db.auth_codes', 'value')],
            'password' => ['required', 'string', 'min:' . Password::LENGTH, 'confirmed'],
        ];
    }
}
