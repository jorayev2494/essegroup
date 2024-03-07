<?php

namespace App\Http\Requests\Api\Company\Authentication\Restore;

use Illuminate\Foundation\Http\FormRequest;

class RestorePasswordLinkRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
        ];
    }
}
