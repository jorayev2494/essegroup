<?php

namespace App\Http\Requests\Api\Admin\Company\Company\Employee;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Project\Infrastructure\Services\Auth\AuthManager;

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
            'email' => [
                'required',
                'email',
                Rule::unique('admin_db.company_employees', 'email')
                    ->ignore($this->route('uuid', AuthManager::employee()?->getUuid()->value), 'uuid'),
            ],
            'avatar' => [
                'nullable',
                'file',
                'max:' . config('filesystems.file_max_size'),
                'mimetypes:image/jpeg,image/png',
            ],
            'company_uuid' => [
                'required',
                Rule::exists('admin_db.company_companies', 'uuid'),
            ],
        ];
    }
}
