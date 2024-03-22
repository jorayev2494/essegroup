<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Infrastructure\Country\Filters;

use Project\Shared\Contracts\ArrayableInterface;
use Symfony\Component\HttpFoundation\Request;

readonly class QueryFilter implements ArrayableInterface
{
    private function __construct(
        public ?string $companyUuid
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
