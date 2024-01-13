<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\Admin\Company\Company;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CompanyUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $uuid = $this->route('uuid');

        return [
            'name' => ['required', 'string', Rule::unique('pgsql_admin.company_companies', 'name')->ignore($uuid, 'uuid')],
            'domain' => ['required', 'string', 'alpha', Rule::unique('pgsql_admin.company_companies', 'domain')->ignore($uuid, 'uuid')],
        ];
    }
}
