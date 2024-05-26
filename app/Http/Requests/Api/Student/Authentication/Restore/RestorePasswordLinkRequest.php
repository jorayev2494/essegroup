<?php

namespace App\Http\Requests\Api\Student\Authentication\Restore;

use Illuminate\Foundation\Http\FormRequest;

class RestorePasswordLinkRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
        ];
    }
}
