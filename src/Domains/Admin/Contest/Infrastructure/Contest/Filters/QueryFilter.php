<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Contest\Infrastructure\Contest\Filters;

use Project\Shared\Infrastructure\Filters\BaseQueryFilter;
use Symfony\Component\HttpFoundation\Request;

readonly class QueryFilter extends BaseQueryFilter
{
    private function __construct(
        public array $wonStudentUuids
    ) { }

    public static function makeFromRequest(Request $request): static
    {
        return self::makeFromArray($request->query->all('filters'));
    }

    public static function makeFromArray(array $data): static
    {
        return new self(
            $data['won_student_uuids'] ?? [],
        );
    }

    public function toArray(): array
    {
        return [
            'won_student_uuids' => $this->wonStudentUuids,
        ];
    }
}
