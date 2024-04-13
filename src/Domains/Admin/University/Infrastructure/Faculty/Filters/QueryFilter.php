<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Infrastructure\Faculty\Filters;

use Project\Shared\Infrastructure\Filters\BaseQueryFilter;
use Symfony\Component\HttpFoundation\Request;

readonly class QueryFilter extends BaseQueryFilter
{
    private function __construct(
        public array $countryUuids,
        public array $languageUuids,
        public array $degreeUuids,
        public array $universityUuids,
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
            $data['country_uuids'] ?? [],
            $data['language_uuids'] ?? [],
            $data['degree_uuids'] ?? [],
            $data['university_uuids'] ?? [],
            $data['alias_uuids'] ?? [],
        );
    }

    #[\Override]
    public function toArray(): array
    {
        return [
            'country_uuids' => $this->countryUuids,
            'language_uuids' => $this->languageUuids,
            'degree_uuids' => $this->degreeUuids,
            'university_uuids' => $this->universityUuids,
            'alias_uuids' => $this->aliasUuids,
        ];
    }
}
