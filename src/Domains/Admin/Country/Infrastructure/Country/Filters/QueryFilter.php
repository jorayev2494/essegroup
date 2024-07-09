<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Country\Infrastructure\Country\Filters;

use Project\Shared\Infrastructure\Filters\BaseQueryFilter;
use Symfony\Component\HttpFoundation\Request;

readonly class QueryFilter extends BaseQueryFilter
{
    private function __construct(
        public array $aliasUuids,
        public array $languageUuids,
        public array $universityUuids,
        public array $facultyUuids,
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
            $data['language_uuids'] ?? [],
            $data['university_uuids'] ?? [],
            $data['faculty_uuids'] ?? [],
        );
    }

    #[\Override]
    public function toArray(): array
    {
        return [
            'alias_uuids' => $this->aliasUuids,
            'language_uuids' => $this->languageUuids,
            'university_uuids' => $this->universityUuids,
            'faculty_uuids' => $this->facultyUuids,
        ];
    }
}
