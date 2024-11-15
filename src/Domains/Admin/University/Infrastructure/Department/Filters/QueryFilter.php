<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Infrastructure\Department\Filters;

use Project\Shared\Infrastructure\Filters\BaseQueryFilter;
use Symfony\Component\HttpFoundation\Request;

readonly class QueryFilter extends BaseQueryFilter
{
    private function __construct(
        public array $countryUuids,
        public array $aliasUuids,
        public array $languageUuids,
        public array $degreeUuids,
        public array $universityUuids,
        public array $departmentNameUuids,
        public array $facultyUuids,
        public array $facultyNameUuids,
        public array $uuids
    ) { }

    public static function makeFromRequest(Request $request): static
    {
        return self::makeFromArray($request->query->all('filters'));
    }

    public static function makeFromArray(array $data): static
    {
        return new self(
            $data['country_uuids'] ?? [],
            $data['alias_uuids'] ?? [],
            $data['language_uuids'] ?? [],
            $data['degree_uuids'] ?? [],
            $data['university_uuids'] ?? [],
            $data['department_name_uuids'] ?? [],
            $data['faculty_uuids'] ?? [],
            $data['faculty_name_uuids'] ?? [],
            $data['uuids'] ?? [],
        );
    }

    #[\Override]
    public function toArray(): array
    {
        return [
            'country_uuids' => $this->countryUuids,
            'alias_uuids' => $this->aliasUuids,
            'language_uuids' => $this->languageUuids,
            'degree_uuids' => $this->degreeUuids,
            'university_uuids' => $this->universityUuids,
            'department_name_uuids' => $this->departmentNameUuids,
            'faculty_uuids' => $this->facultyUuids,
            'faculty_name_uuids' => $this->facultyNameUuids,
            'uuids' => $this->uuids,
        ];
    }
}
