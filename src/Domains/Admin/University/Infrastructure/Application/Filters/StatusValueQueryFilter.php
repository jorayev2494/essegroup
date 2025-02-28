<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Infrastructure\Application\Filters;

use Project\Shared\Infrastructure\Filters\BaseQueryFilter;
use Symfony\Component\HttpFoundation\Request;

readonly class StatusValueQueryFilter extends BaseQueryFilter
{
    private function __construct(
        public array $companyUuids
    ) { }

    public static function makeFromRequest(Request $request): static
    {
        return self::makeFromArray($request->query->all('filters'));
    }

    public static function makeFromArray(array $data): static
    {
        return new self(
            $data['company_uuids'] ?? []
        );
    }

    public function toArray(): array
    {
        return [
            'company_uuids' => $this->companyUuids,
        ];
    }
}
