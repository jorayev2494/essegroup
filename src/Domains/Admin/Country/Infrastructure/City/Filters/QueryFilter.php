<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Country\Infrastructure\City\Filters;

use Project\Shared\Contracts\ArrayableInterface;
use Symfony\Component\HttpFoundation\Request;

readonly class QueryFilter implements ArrayableInterface
{
    private function __construct(
        public ?string $companyUuid,
        public array $countryUuids
    ) {

    }

    public static function makeFromRequest(Request $request): self
    {
        return self::makeFromArray($request->query->all('filters'));
    }

    public static function makeFromArray(array $data): self
    {
        return new self(
            $data['company_uuid'] ?? null,
            $data['country_uuids'] ?? [],
        );
    }

    #[\Override]
    public function toArray(): array
    {
        return [
            'company_uuid' => $this->companyUuid,
            'country_uuids' => $this->countryUuids,
        ];
    }
}
