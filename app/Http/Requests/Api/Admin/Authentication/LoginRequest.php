<?php

namespace App\Http\Requests\Api\Admin\Authentication;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
           'device_id' => $this->headers->get('x-device-id'),
        ]);
    }

    public function rules(): array
    {
        return [
            'device_id' => ['required', 'string'],
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }
}
