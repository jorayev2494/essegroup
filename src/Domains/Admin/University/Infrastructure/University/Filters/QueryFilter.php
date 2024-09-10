<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Infrastructure\University\Filters;

use Project\Shared\Infrastructure\Filters\BaseQueryFilter;
use Symfony\Component\HttpFoundation\Request;

readonly class QueryFilter extends BaseQueryFilter
{
    private function __construct(
        public array $countryUuids,
        public array $aliasUuids,
        public array $cityUuids,
        public array $facultyUuids,
        public array $departmentUuids,
        public array $departmentNameUuids,
        public array $degreeUuids,
        public array $languageUuids,
        public bool $onlyInCountryList,
        public bool $isForForeign,
        public ?bool $topPosition
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
            $data['city_uuids'] ?? [],
            $data['faculty_uuids'] ?? [],
            $data['department_uuids'] ?? [],
            $data['department_name_uuids'] ?? [],
            $data['degree_uuids'] ?? [],
            $data['language_uuids'] ?? [],
            (bool) ($data['only_in_country_list'] ?? false),
            (bool) ($data['is_for_foreign'] ?? false),
            array_key_exists('top_position', $data) ? $data['top_position'] : null,
        );
    }

    public function toArray(): array
    {
        return [
            'country_uuids' => $this->countryUuids,
            'alias_uuids' => $this->aliasUuids,
            'city_uuids' => $this->cityUuids,
            'faculty_uuids' => $this->facultyUuids,
            'department_uuids' => $this->departmentUuids,
            'department_name_uuids' => $this->departmentNameUuids,
            'degree_uuids' => $this->degreeUuids,
            'language_uuids' => $this->languageUuids,
            'only_in_country_list' => $this->onlyInCountryList,
            'is_for_foreign' => $this->isForForeign,
            'top_position' => $this->topPosition,
        ];
    }
}
