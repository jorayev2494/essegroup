<?php

namespace App\Http\Requests\Api\Public\Student\Student;

use App\Rules\ValidatePassportNumberRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Project\Domains\Admin\Student\Domain\Student\ValueObjects\Enums\Gender;
use Project\Domains\Admin\Student\Domain\Student\ValueObjects\Enums\MaritalType;

class StoreRequest extends FormRequest
{
    private static array $documentMimeTypes = [
        'application/pdf',
        'image/jpeg',
        'image/png',
    ];

    // protected function prepareForValidation(): void
    // {
    //     /** @var CompanyRepositoryInterface $companyRepository */
    //     $companyRepository = resolve(CompanyRepositoryInterface::class);
    //
    //     /** @var Company|null $company */
    //     $company = $companyRepository->findMain();
    //     if ($company !== null) {
    //         $this->merge([
    //             'company_uuid' => $company->getUuid()->value,
    //         ]);
    //     }
    // }

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
                'max:255',
                new ValidatePassportNumberRule(),
                Rule::unique('admin_db.student_students', 'passport_number'),
            ],
            'email' => [
                'required',
                'email',
                'max:75',
                Rule::unique('admin_db.student_students', 'email'),
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
            'high_school_country_uuid' => [
                'required',
                'uuid',
                'max:255',
                Rule::exists('admin_db.country_countries', 'uuid'),
            ],

            'passport' => ['required', 'file', 'mimetypes:' . implode(',', self::$documentMimeTypes)],
            'passport_translation' => ['required', 'file', 'mimetypes:' . implode(',', self::$documentMimeTypes)],
            'school_attestat' => ['required', 'file', 'mimetypes:' . implode(',', self::$documentMimeTypes)],
            'school_attestat_translation' => ['required', 'file', 'mimetypes:' . implode(',', self::$documentMimeTypes)],
            'transcript' => ['required', 'file', 'mimetypes:' . implode(',', self::$documentMimeTypes)],
            'transcript_translation' => ['required', 'file', 'mimetypes:' . implode(',', self::$documentMimeTypes)],
            'equivalence_document' => ['required', 'file', 'mimetypes:' . implode(',', self::$documentMimeTypes)],
            'biometric_photo' => ['required', 'file', 'mimetypes:' . implode(',', self::$documentMimeTypes)],
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
            'passport_date_of_issue' => ['nullable', 'date'],
            'passport_date_of_expiry' => ['nullable', 'date'],
            'high_school_name' => [
                'nullable',
                'string',
                'max:255',
            ],
            'high_school_grade_average' => [
                'nullable',
                'string',
                'max:5',
            ],
        ];
    }

    private function getHostName(): string
    {
        [$hostName] = explode(':', $this->server('HTTP_HOST'));

        return $hostName;
    }
}
