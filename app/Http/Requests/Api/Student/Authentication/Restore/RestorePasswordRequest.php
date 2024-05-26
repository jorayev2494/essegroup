<?php

namespace App\Http\Requests\Api\Student\Authentication\Restore;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RestorePasswordRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'token' => ['required', 'string', Rule::exists('admin_db.student_auth_codes', 'value')],
            'password' => ['required', 'string', 'confirmed'],
        ];
    }
}
