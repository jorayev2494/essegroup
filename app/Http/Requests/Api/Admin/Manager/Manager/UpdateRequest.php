<?php

namespace App\Http\Requests\Api\Admin\Manager\Manager;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
                    ->ignore($this->route('uuid'),'uuid'),
            ],
        ];
    }
}