<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Infrastructure\Department\Filters;

use Project\Shared\Infrastructure\Filters\BaseQueryFilter;
use Symfony\Component\HttpFoundation\Request;

readonly class QueryFilter extends BaseQueryFilter
{
    private function __construct(
        public ?string $universityUuid,
        public ?string $facultyUuid
    ) {

    }

    public static function makeFromRequest(Request $request): static
    {
        return self::makeFromArray($request->query->all('filters'));
    }

    public static function makeFromArray(array $data): static
    {
        return new self(
            $data['university_uuid'] ?? null,
            $data['faculty_uuid'] ?? null,
        );
    }

    #[\Override]
    public function toArray(): array
    {
        return [
            'university_uuid' => $this->universityUuid,
            'faculty_uuid' => $this->facultyUuid,
        ];
    }
}
