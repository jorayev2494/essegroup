<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\University\Queries\Search;

use Project\Domains\Admin\University\Infrastructure\University\Filters\QueryFilter;
use Project\Shared\Domain\Bus\Query\BaseHttpQueryParams;
use Project\Shared\Infrastructure\Filters\BaseSearch;
use Project\Shared\Infrastructure\Repository\Doctrine\PaginatorHttpQueryParams;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

readonly class Query extends BaseHttpQueryParams
{
    public PaginatorHttpQueryParams $paginate;

    public BaseSearch $search;

    public QueryFilter $filter;

    protected function fromRequest(SymfonyRequest $request): static
    {
        $this->paginate = PaginatorHttpQueryParams::makeFromRequest($request);
        $this->search = BaseSearch::makeFromRequest($request);
        $this->filter = QueryFilter::makeFromRequest($request);

        return $this;
    }

    protected function fromArray(array $data): static
    {
        $this->paginate = PaginatorHttpQueryParams::makeFromArray($data);
        $this->search = BaseSearch::makeFromArray($data);
        $this->filter = QueryFilter::makeFromArray($data);

        return $this;
    }

    public function toArray(): array
    {
        return [
            ...$this->paginate->toArray(),
            ...$this->search->toArray(),
            ...$this->filter->toArray(),
        ];
    }
}
