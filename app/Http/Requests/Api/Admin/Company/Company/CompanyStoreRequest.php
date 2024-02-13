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
            'name' => ['required', 'string'],
            'domain' => ['required', 'string', 'alpha'],
        ];
    }
}
