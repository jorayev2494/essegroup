<?php

namespace App\Http\Requests\Api\Admin\Manager\Role\Permission;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePermissionsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'permission_ids' => [
                // 'required',
                'array',
            ],
            'permission_ids.*' => [
                Rule::exists('admin_db.manager_role_permissions', 'id')
            ],
        ];
    }
}
