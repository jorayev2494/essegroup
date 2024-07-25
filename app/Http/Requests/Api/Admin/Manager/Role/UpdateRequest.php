<?php

namespace App\Http\Requests\Api\Admin\Manager\Role;

use App\Rules\ValidateTranslationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'translations' => [
                'required',
                new ValidateTranslationRule(['name']),
            ],
            'translations.*.name' => [
                Rule::unique('admin_db.manager_role_translations', 'content')
                    ->ignore($this->route('uuid'), 'role_uuid'),
            ],
            'is_active' => ['required', 'boolean'],
        ];
    }
}
