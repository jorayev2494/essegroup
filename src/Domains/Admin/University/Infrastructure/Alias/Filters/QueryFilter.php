<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Infrastructure\Alias\Filters;

use Project\Shared\Infrastructure\Filters\BaseQueryFilter;
use Symfony\Component\HttpFoundation\Request;

readonly class QueryFilter extends BaseQueryFilter
{
    private function __construct(
        public array $countryUuids,
        public array $degreeUuids,
        public array $languageUuids,
        public array $universityUuids,
        public array $facultyUuids,
        public array $departmentUuids
    ) {

    }

    public static function makeFromRequest(Request $request): static
    {
        return self::makeFromArray($request->query->all('filters'));
    }

    public static function makeFromArray(array $data): static
    {
        return new self(
            $data['country_uuids'] ?? [],
            $data['degree_uuids'] ?? [],
            $data['language_uuids'] ?? [],
            $data['university_uuids'] ?? [],
            $data['faculty_uuids'] ?? [],
            $data['department_uuids'] ?? [],
        );
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [

        ];
    }
}
