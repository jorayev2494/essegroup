<?php

declare(strict_types=1);

namespace Project\Shared\Domain\Bus\Query;

use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

abstract readonly class BaseHttpQueryParams implements QueryInterface
{
    private function __construct(
        // public PaginatorHttpQueryParams $paginatorHttpQueryParams,
        // public array $filters,
        // public readonly ?string $search,
        // public readonly ?string $searchBy,
        // public readonly ?string $sortBy,
        // public readonly ?bool $sortRule,
    ) {

    }

    public static function makeFromRequest(SymfonyRequest $request): static
    {
        return (new static(
            // paginatorHttpQueryParams: PaginatorHttpQueryParams::makeFromRequest($request),
            // filters: self::makeFilters($request->get('filters', [])),
            // search: $request->query->get('search'),
            // searchBy: $request->query->get('search_by'),
            // sortBy: $request->query->get('sort_by', 'created_at'),
            // sortRule: $request->query->getBoolean('sort_rule'),
        ))->fromRequest($request);
    }

    abstract protected function fromRequest(SymfonyRequest $request): static;

    public static function makeFromArray(array $data): static
    {
        return (new static())->fromArray($data);
    }

    abstract protected function fromArray(array $data): static;
}
