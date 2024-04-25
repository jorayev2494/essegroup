<?php

namespace App\Http\Requests\Api\Admin\Company\Company\Employee;

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
            'email' => [
                'required',
                'email'
            ],
            'avatar' => [
                'nullable',
                'file',
                'mimetypes:image/jpeg,image/png',
            ],
            'company_uuid' => [
                'required',
                Rule::exists('admin_db.company_companies', 'uuid'),
            ],
        ];
    }
}
