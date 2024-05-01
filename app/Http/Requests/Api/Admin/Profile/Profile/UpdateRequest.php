<?php

namespace App\Http\Requests\Api\Admin\Profile\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Project\Infrastructure\Services\Auth\AuthManager;
use Project\Infrastructure\Services\Authentication\Enums\GuardType;

class UpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_name' => [
                'required',
            ],
            'last_name' => [
                'required',
            ],
            'avatar' => ['nullable', 'file', 'mimetypes:image/jpeg,image/png'],
            'email' => [
                'required',
                'email',
                Rule::unique('admin_db.auth_members', 'email')
                    ->ignore(AuthManager::uuid(GuardType::MANAGER)->value,'uuid'),
            ],
        ];
    }
}
