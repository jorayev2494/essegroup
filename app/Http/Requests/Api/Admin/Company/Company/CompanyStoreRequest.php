<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\Admin\Company\Company;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CompanyStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

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
            'domain' => [
                'required',
                'string',
                'alpha',
                Rule::unique('admin_db.company_companies', 'domain'),
            ],
            'logo' => [
                'required',
                'file',
                'mimetypes:image/*',
                // Rule::dimensions()->width(self::LOGO_WIDTH)->height(self::LOGO_HEIGHT),
            ],
        ];
    }
}
