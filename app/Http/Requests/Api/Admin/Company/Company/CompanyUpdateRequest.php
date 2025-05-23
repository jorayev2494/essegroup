<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\Admin\Company\Company;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CompanyUpdateRequest extends FormRequest
{
    private const int LOGO_WIDTH = 400;

    private const int LOGO_HEIGHT = 400;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                Rule::unique('admin_db.company_companies', 'name')->whereNot('uuid', $this->route('uuid')),
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('admin_db.company_companies', 'email')->whereNot('uuid', $this->route('uuid')),
            ],
            'logo' => [
                'nullable',
                'file',
                'max:' . config('filesystems.file_max_size'),
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
