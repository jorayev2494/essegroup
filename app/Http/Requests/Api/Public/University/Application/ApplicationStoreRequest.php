<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\Public\University\Application;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Project\Domains\Admin\Company\Domain\Company\Company;
use Project\Domains\Admin\Company\Domain\Company\CompanyRepositoryInterface;
use Project\Domains\Admin\Company\Domain\Company\ValueObjects\Domain;

class ApplicationStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        /** @var CompanyRepositoryInterface $companyRepository */
        $companyRepository = resolve(CompanyRepositoryInterface::class);

        /** @var Company $company */
        $company = $companyRepository->findByDomain(Domain::fromValue($this->getHostName()));
        if ($company->getUuid()->isNotNull()) {
            $this->merge([
                'company_uuid' => $company->getUuid()->value,
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'university_uuid' => [
                'required',
                'string',
                'max:255',
                Rule::exists('admin_db.university_universities', 'uuid'),
            ],
            // 'faculty_uuid' => [
            //     'required',
            //     'string',
            //     'max:255',
            //     Rule::exists('admin_db.faculty_faculties', 'uuid'),
            // ],
            'department_uuids' => [
                'required',
            ],
            'country_uuid' => [
                'required',
                'string',
                'max:255',
                Rule::exists('admin_db.country_countries', 'uuid'),
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
                'file',
                // 'mimetypes:application/pdf',
            ],
            'is_agreed_to_share_data' => ['required', 'boolean', 'in:true,1'],

            'company_uuid' => [
                'nullable',
                'string',
                'max:255',
                Rule::exists('admin_db.company_companies', 'uuid'),
            ],
            'father_name' => ['nullable', 'string', 'max:255'],
            'mother_name' => ['nullable', 'string', 'max:255'],
            'friend_phone' => ['nullable', 'string', 'max:255'],
            'home_address' => ['nullable', 'string', 'max:255'],
        ];
    }

    private function getHostName(): string
    {
        [$hostName] = explode(':', $this->server('HTTP_HOST'));

        return $hostName;
    }
}
