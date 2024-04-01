<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Country\Infrastructure\City\Filters;

use Project\Shared\Contracts\ArrayableInterface;
use Symfony\Component\HttpFoundation\Request;

readonly class QueryFilter implements ArrayableInterface
{
    private function __construct(
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
            $data['country_uuids'] ?? [],
        );
    }

    #[\Override]
    public function toArray(): array
    {
        return [
            'country_uuids' => $this->countryUuids,
        ];
    }
}
