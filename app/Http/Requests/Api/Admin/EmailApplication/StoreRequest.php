<?php

namespace App\Http\Requests\Api\Admin\EmailApplication;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'father_first_name' => ['required', 'string'],
            'mother_first_name' => ['required', 'string'],
            'phone' => ['required', 'string'],
            'additional_phone' => ['required', 'string'],
            'note' => ['nullable', 'string'],
        ];
    }
}
