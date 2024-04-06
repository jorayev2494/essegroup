<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Infrastructure\Department\Filters;

use Project\Shared\Infrastructure\Filters\BaseQueryFilter;
use Symfony\Component\HttpFoundation\Request;

readonly class QueryFilter extends BaseQueryFilter
{
    private function __construct(
        public array $universityUuids,
        public ?string $facultyUuid,
        public array $aliasUuids
    ) {

    }

    public static function makeFromRequest(Request $request): static
    {
        return self::makeFromArray($request->query->all('filters'));
    }

    public static function makeFromArray(array $data): static
    {
        return new self(
            $data['university_uuids'] ?? [],
            $data['faculty_uuid'] ?? null,
            $data['alias_uuids'] ?? [],
        );
    }

    #[\Override]
    public function toArray(): array
    {
        return [
            'university_uuids' => $this->universityUuids,
            'faculty_uuid' => $this->facultyUuid,
            'alias_uuids' => $this->aliasUuids,
        ];
    }
}
