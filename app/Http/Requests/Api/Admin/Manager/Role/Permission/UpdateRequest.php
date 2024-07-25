<?php

namespace App\Http\Requests\Api\Admin\Manager\Role\Permission;

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
                new ValidateTranslationRule(['label']),
            ],
            'translations.*.label' => [
                Rule::unique('admin_db.manager_role_permission_translations', 'content')
                    ->ignore($this->route('id'), 'permission_id'),
            ],
            'is_active' => ['required', 'boolean'],
        ];
    }
}
