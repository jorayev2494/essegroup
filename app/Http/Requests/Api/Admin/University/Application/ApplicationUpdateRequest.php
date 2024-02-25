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
            'full_name' => ['required', 'string', 'max:255'],
            'birthday' => ['required', 'date', 'max:255'],
            'passport_number' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'min:5', 'max:255'],

            'university_uuid' => [
                'required',
                'string',
                'max:255',
                Rule::exists('pgsql_admin.university_universities', 'uuid'),
            ],
            'faculty_uuid' => [
                'required',
                'string',
                'max:255',
                Rule::exists('pgsql_admin.faculty_faculties', 'uuid'),
            ],
            'country_uuid' => [
                'required',
                'string',
                'max:255',
                Rule::exists('pgsql_admin.university_countries', 'uuid'),
            ],

            'status' => ['required', Rule::in(StatusEnum::MANAGEMENT_NOTE_REQUIRED)],
            'note' => [
                'nullable',
                'string',
                'max:500',
                Rule::requiredIf(StatusEnum::managementNoteRequired(StatusEnum::from($this->get('status'))))
            ],

            'father_name' => ['nullable', 'string', 'max:255'],
            'mother_name' => ['nullable', 'string', 'max:255'],
            'friend_phone' => ['nullable', 'string', 'max:255'],
            'home_address' => ['nullable', 'string', 'max:255'],
        ];
    }
}
