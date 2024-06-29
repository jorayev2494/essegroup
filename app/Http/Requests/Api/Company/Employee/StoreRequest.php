<?php

namespace App\Http\Requests\Api\Company\Employee;

use Illuminate\Foundation\Http\FormRequest;

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
            'email' => [
                'required',
                'email'
            ],
            'avatar' => [
                'nullable',
                'file',
                'max:' . config('filesystems.file_max_size'),
                'mimetypes:image/jpeg,image/png',
            ],
        ];
    }
}
