<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Infrastructure\University\Filters;

use Symfony\Component\HttpFoundation\Request;

readonly class HttpQueryFilterDTO
{
    private function __construct(
        public ?string $companyUuid
    ) {

    }

    public static function makeFromRequest(Request $request): self
    {
        return new self(
            $request->query->get('filter_by_company_uuid')
        );
    }

    public static function makeFromArray(array $data): self
    {
        return new self(
            $data['filter_by_company_uuid'] ?? null,
        );
    }
}
