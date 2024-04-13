<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Language\Infrastructure\Language\Filters;

use Project\Shared\Infrastructure\Filters\BaseQueryFilter;
use Symfony\Component\HttpFoundation\Request;

readonly class QueryFilter extends BaseQueryFilter
{
    private function __construct(
        public array $aliasUuids,
        public array $countryUuids,
        public array $universityUuids,
        public array $facultyUuids,
        public array $departmentUuids,
    ) {

    }

    public static function makeFromRequest(Request $request): static
    {
        return self::makeFromArray($request->query->all('filters'));
    }

    public static function makeFromArray(array $data): static
    {
        return new self(
            $data['alias_uuids'] ?? [],
            $data['country_uuids'] ?? [],
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
            'alias_uuids' => $this->aliasUuids,
            'country_uuids' => $this->countryUuids,
            'university_uuids' => $this->universityUuids,
            'faculty_uuids' => $this->facultyUuids,
            'department_uuids' => $this->departmentUuids,
        ];
    }
}
