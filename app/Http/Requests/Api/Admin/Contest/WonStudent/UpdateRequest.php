<?php

namespace App\Http\Requests\Api\Admin\Contest\WonStudent;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'gift_given_at' => [
                'nullable',
                'date',
            ],
            'note' => [
                'nullable',
                'max: 500',
            ],
        ];
    }
}
