<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\Application\Queries\Index;

use Project\Shared\Domain\Bus\Query\BaseHttpQueryParams;
use Project\Shared\Infrastructure\Filters\BaseSearch;
use Project\Shared\Infrastructure\Repository\Doctrine\PaginatorHttpQueryParams;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Project\Domains\Admin\University\Infrastructure\Application\Filters\QueryFilter;

readonly class Query extends BaseHttpQueryParams
{
    public PaginatorHttpQueryParams $paginator;

    public QueryFilter $filter;

    public BaseSearch $search;

    protected function fromRequest(SymfonyRequest $request): static
    {
        $this->paginator = PaginatorHttpQueryParams::makeFromRequest($request);
        $this->filter = QueryFilter::makeFromRequest($request);
        $this->search = BaseSearch::makeFromRequest($request);

        return $this;
    }

    protected function fromArray(array $data): static
    {
        $this->paginator = PaginatorHttpQueryParams::makeFromArray($data);
        $this->filter = QueryFilter::makeFromArray($data);
        $this->search = BaseSearch::makeFromArray($data);

        return $this;
    }

    public function toArray(): array
    {
        return [
            ...$this->paginator->toArray(),
            ...$this->filter->toArray(),
            ...$this->search->toArray(),
        ];
    }
}
