<?php

namespace App\Http\Requests\Api\Company\Authentication;

use Illuminate\Foundation\Http\FormRequest;

class RefreshTokenRequest extends FormRequest
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
            'refresh_token' => ['required', 'string'],
        ];
    }
}
