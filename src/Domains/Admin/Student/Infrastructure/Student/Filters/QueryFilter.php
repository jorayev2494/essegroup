<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Student\Infrastructure\Student\Filters;

use Project\Shared\Contracts\ArrayableInterface;
use Symfony\Component\HttpFoundation\Request;

readonly class QueryFilter implements ArrayableInterface
{
    private function __construct(
        public array $companyUuids,
        public array $universityUuids,
        public array $statusValueUuids
    ) { }

    public static function makeFromRequest(Request $request): self
    {
        return self::makeFromArray($request->query->all('filters'));
    }

    public static function makeFromArray(array $data): self
    {
        return new self(
            $data['company_uuids'] ?? [],
            $data['university_uuids'] ?? [],
            $data['status_value_uuids'] ?? []
        );
    }

    #[\Override]
    public function toArray(): array
    {
        return [
            'company_uuids' => $this->companyUuids,
            'university_uuids' => $this->universityUuids,
            'status_value_uuids' => $this->statusValueUuids,
        ];
    }
}
