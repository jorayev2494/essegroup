<?php

namespace App\Http\Requests\Api\Admin\Currency\Currency;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'value' => [
                'required',
                'numeric',
            ],
            'code' => [
                'required',
                'max:3',
                Rule::unique('admin_db.currency_currencies', 'code'),
            ],
            'symbol' => [
                'required',
                'max:1',
                Rule::unique('admin_db.currency_currencies', 'symbol'),
            ],
            'description' => [
                'nullable',
            ],
            'is_active' => [
                'required',
                'boolean',
            ],
        ];
    }
}
