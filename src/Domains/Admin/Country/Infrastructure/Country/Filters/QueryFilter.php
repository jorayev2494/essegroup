<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Country\Infrastructure\Country\Filters;

use Project\Shared\Infrastructure\Filters\BaseQueryFilter;
use Symfony\Component\HttpFoundation\Request;

readonly class QueryFilter extends BaseQueryFilter
{
    private function __construct(
        public ?string $companyUuid
    ) {

    }

    public static function makeFromRequest(Request $request): static
    {
        return self::makeFromArray($request->query->all('filters'));
    }

    public static function makeFromArray(array $data): static
    {
        return new self(
            $data['company_uuid'] ?? null,
        );
    }

    #[\Override]
    public function toArray(): array
    {
        return [
            'company_uuid' => $this->companyUuid,
        ];
    }
}
