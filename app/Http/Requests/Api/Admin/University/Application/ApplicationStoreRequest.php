<?php

namespace App\Http\Requests\Api\Admin\University\Application;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Project\Domains\Admin\University\Domain\Application\StatusEnum;

class ApplicationStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'university_uuid' => [
                'required',
                'string',
                'max:255',
                Rule::exists('pgsql_admin.university_universities', 'uuid'),
            ],
//            'faculty_uuid' => [
//                'required',
//                'string',
//                'max:255',
//                Rule::exists('pgsql_admin.faculty_faculties', 'uuid'),
//            ],
            'department_uuids' => [
                'required',
            ],
            'country_uuid' => [
                'required',
                'string',
                'max:255',
                Rule::exists('pgsql_admin.university_countries', 'uuid'),
            ],
            'full_name' => ['required', 'string', 'max:255'],
            'birthday' => ['required', 'date', 'max:255'],
            'passport_number' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'min:5', 'max:255'],
            'passport' => ['required', 'file', 'mimetypes:application/pdf'],
            'passport_translation' => ['required', 'file', 'mimetypes:application/pdf'],
            'school_attestat' => ['required', 'file', 'mimetypes:application/pdf'],
            'school_attestat_translation' => ['required', 'file', 'mimetypes:application/pdf'],
            'transcript' => ['required', 'file', 'mimetypes:application/pdf'],
            'transcript_translation' => ['required', 'file', 'mimetypes:application/pdf'],
            'equivalence_document' => ['required', 'file', 'mimetypes:application/pdf'],
            'biometric_photo' => ['required', 'file', 'mimetypes:application/pdf'],
            'additional_documents' => ['array', 'max:5'],
            'additional_documents.*.description' => [
                'string',
                'max:255',
            ],
            'additional_documents.*.document' => [
                'file', 'mimetypes:application/pdf'
            ],
            // 'is_agreed_to_share_data' => ['required', 'boolean', 'in:true,1'],

            // 'status' => ['required', Rule::in(StatusEnum::cases())],
            // 'note' => [
            //     'nullable',
            //     'string',
            //     'max:500',
            //     Rule::requiredIf(StatusEnum::managementNoteRequired(StatusEnum::from($this->get('status'))))
            // ],

            'company_uuid' => [
                'required',
                'string',
                'max:255',
                Rule::exists('pgsql_admin.university_companies', 'uuid'),
            ],
            'father_name' => ['nullable', 'string', 'max:255'],
            'mother_name' => ['nullable', 'string', 'max:255'],
            'friend_phone' => ['nullable', 'string', 'max:255'],
            'home_address' => ['nullable', 'string', 'max:255'],
        ];
    }
}
