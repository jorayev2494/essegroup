<?php

namespace App\Http\Requests\Api\Admin\Profile\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Project\Domains\Admin\Manager\Domain\Manager\ValueObjects\Password;

class ChangePasswordRequest extends FormRequest
{
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
            'current_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'min:' . Password::LENGTH, 'different:current_password', 'confirmed'],
        ];
    }
}
