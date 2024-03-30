<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Infrastructure\University\Filters;

use Project\Shared\Infrastructure\Filters\BaseQueryFilter;
use Symfony\Component\HttpFoundation\Request;

readonly class QueryFilter extends BaseQueryFilter
{
    private function __construct(
        public ?string $companyUuid,
        public ?array $countryUuids,
        public ?array $cityUuids,
        public ?array $facultyUuids,
        public ?array $departmentUuids,
        public ?array $degreeUuids,
        public bool $onlyInCountryList
    ) {

    }

    public static function makeFromRequest(Request $request): static
    {
        return self::makeFromArray($request->query->all('filters'));
    }

    public static function makeFromArray(array $data): static
    {
        return new self(
            $data['company_uuid'] ?? null,
            $data['country_uuids'] ?? [],
            $data['city_uuids'] ?? [],
            $data['faculty_uuids'] ?? [],
            $data['department_uuids'] ?? [],
            $data['degree_uuids'] ?? [],
            $data['only_in_country_list'] ?? false,
        );
    }

    public function toArray(): array
    {
        return [
            'company_uuid' => $this->companyUuid,
            'country_uuids' => $this->countryUuids,
            'city_uuids' => $this->cityUuids,
            'faculty_uuids' => $this->facultyUuids,
            'department_uuids' => $this->departmentUuids,
            'degree_uuids' => $this->degreeUuids,
            'only_in_country_list' => $this->onlyInCountryList,
        ];
    }
}
