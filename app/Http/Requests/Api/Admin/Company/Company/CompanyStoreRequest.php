<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\Admin\Company\Company;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CompanyStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            // 'logo' => ['required', 'file'],
            'name' => [
                'required',
                'string',
                Rule::unique('admin_db.company_companies', 'name'),
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('admin_db.company_companies', 'email'),
            ],
            'logo' => [
                'required',
                'file',
                'mimetypes:image/*',
                // Rule::dimensions()->width(self::LOGO_WIDTH)->height(self::LOGO_HEIGHT),
            ],
            'is_main' => [
                'required',
                'boolean',
                Rule::unique('admin_db.company_companies', 'is_main')
                    ->where('is_main', true)
                    ->ignore($this->route('uuid'),'uuid'),
            ],
        ];
    }
}
