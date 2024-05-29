<?php

namespace App\Http\Requests\Api\Admin\Student\Student;

use App\Rules\ValidatePassportNumberRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Project\Domains\Admin\Student\Domain\Student\ValueObjects\Enums\Gender;
use Project\Domains\Admin\Student\Domain\Student\ValueObjects\Enums\MaritalType;

class UpdateRequest extends FormRequest
{
    private static array $documentMimeTypes = [
        'application/pdf',
        'image/jpeg',
        'image/png',
    ];

    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'avatar' => ['nullable', 'file', 'mimetypes:image/jpeg,image/png'],
            'birthday' => ['required', 'date', 'max:255'],
            'passport_number' => [
                'required',
                'string',
                'max:50',
                new ValidatePassportNumberRule(),
                Rule::unique('admin_db.student_students', 'passport_number')
                    ->ignore($this->route()->parameter('uuid'), 'uuid'),
            ],
            'passport_date_of_issue' => ['required', 'date'],
            'passport_date_of_expiry' => ['required', 'date'],
            'email' => [
                'required',
                'email',
                'max:75',
                Rule::unique('admin_db.student_students', 'email')
                    ->ignore($this->route()->parameter('uuid'), 'uuid'),
            ],
            'phone' => ['required', 'min:5', 'max:50'],

            'nationality_uuid' => [
                'required',
                'uuid',
                'max:255',
                Rule::exists('admin_db.country_countries', 'uuid'),
            ],
            'country_of_residence_uuid' => [
                'required',
                'uuid',
                'max:255',
                Rule::exists('admin_db.country_countries', 'uuid'),
            ],
            'high_school_name' => [
                'required',
                'string',
                'max:255',
            ],
            'high_school_country_uuid' => [
                'required',
                'uuid',
                'max:255',
                Rule::exists('admin_db.country_countries', 'uuid'),
            ],
            'high_school_grade_average' => [
                'required',
                'string',
                'max:5',
            ],

            'passport' => ['nullable', 'file', 'mimetypes:' . implode(',', self::$documentMimeTypes)],
            'passport_translation' => ['nullable', 'file', 'mimetypes:' . implode(',', self::$documentMimeTypes)],
            'school_attestat' => ['nullable', 'file', 'mimetypes:' . implode(',', self::$documentMimeTypes)],
            'school_attestat_translation' => ['nullable', 'file', 'mimetypes:' . implode(',', self::$documentMimeTypes)],
            'transcript' => ['nullable', 'file', 'mimetypes:' . implode(',', self::$documentMimeTypes)],
            'transcript_translation' => ['nullable', 'file', 'mimetypes:' . implode(',', self::$documentMimeTypes)],
            'equivalence_document' => ['nullable', 'file', 'mimetypes:' . implode(',', self::$documentMimeTypes)],
            'biometric_photo' => ['nullable', 'file', 'mimetypes:' . implode(',', self::$documentMimeTypes)],

            'additional_documents' => ['array', 'max:5'],
            'additional_documents.*.description' => [
                'string',
                'max:255',
            ],
            'additional_documents.*.document' => [
                'file',
                'mimetypes:' . implode(',', self::$documentMimeTypes),
            ],

            'company_uuid' => [
                'required',
                'uuid',
                Rule::exists('admin_db.company_companies', 'uuid'),
            ],
            'father_name' => ['nullable', 'string', 'max:255'],
            'mother_name' => ['nullable', 'string', 'max:255'],
            'friend_phone' => ['nullable', 'string', 'max:50'],
            'home_address' => ['nullable', 'string', 'max:255'],
            'gender' => ['nullable', 'string', Rule::in(Gender::cases())],
            'marital_type' => ['nullable', 'string', Rule::in(MaritalType::cases())],
        ];
    }
}
