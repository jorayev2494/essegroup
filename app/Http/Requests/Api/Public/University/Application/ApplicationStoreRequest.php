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
            'student_uuid' => [
                'required',
                'uuid',
                Rule::exists('admin_db.student_students', 'uuid'),
            ],
            'alias_uuid' => [
                'required',
                'uuid',
                Rule::exists('admin_db.university_aliases', 'uuid'),
            ],
            'language_uuid' => [
                'required',
                'uuid',
                Rule::exists('admin_db.language_languages', 'uuid'),
            ],
            'degree_uuid' => [
                'required',
                'uuid',
                Rule::exists('admin_db.university_degrees', 'uuid'),
            ],
            'country_uuid' => [
                'required',
                'uuid',
                Rule::exists('admin_db.country_countries', 'uuid'),
            ],
            'university_uuid' => [
                'required',
                'uuid',
                Rule::exists('admin_db.university_universities', 'uuid'),
            ],
            'department_uuids' => [
                'required',
            ],
            'department_uuids.*' => [
                'uuid',
                Rule::exists('admin_db.university_departments', 'uuid'),
            ],
            'is_agreed_to_share_data' => ['required', 'boolean', 'in:true,1'],
        ];
    }

    private function getHostName(): string
    {
        [$hostName] = explode(':', $this->server('HTTP_HOST'));

        return $hostName;
    }
}
