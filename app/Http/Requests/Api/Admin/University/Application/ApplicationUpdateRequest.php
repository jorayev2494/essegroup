<?php

namespace App\Http\Requests\Api\Admin\University\Application;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Project\Domains\Admin\University\Domain\Application\StatusEnum;

class ApplicationUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'min:5', 'max:255'],
            'status' => ['required', Rule::in(StatusEnum::cases())],
            'note' => ['nullable', 'string', 'max:500'],
        ];
    }
}
