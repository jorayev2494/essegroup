<?php

namespace App\Http\Requests\Api\Admin\Manager\Manager;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
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
            'avatar' => ['required', 'file', 'max:' . config('filesystems.file_max_size'), 'mimetypes:image/jpeg,image/png'],
            'email' => [
                'required',
                'email',
                Rule::unique('admin_db.auth_members', 'email'),
            ],
        ];
    }
}
