<?php

namespace App\Http\Requests\Api\Student\Authentication\Restore;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Project\Domains\Admin\Student\Domain\Student\ValueObjects\Password;

class RestorePasswordRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'token' => ['required', 'string', Rule::exists('admin_db.student_auth_codes', 'value')],
            'password' => ['required', 'string', 'confirmed', 'min:' . Password::LENGTH],
        ];
    }
}
