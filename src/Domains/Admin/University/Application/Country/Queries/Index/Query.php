<?php

namespace Project\Domains\Admin\University\Application\Country\Queries\Index;

use Project\Domains\Admin\University\Infrastructure\Country\Filters\QueryFilter;
use Project\Shared\Domain\Bus\Query\BaseHttpQueryParams;
use Project\Shared\Infrastructure\Repository\Doctrine\PaginatorHttpQueryParams;
use Symfony\Component\HttpFoundation\Request;

readonly class Query extends BaseHttpQueryParams
{
    public PaginatorHttpQueryParams $paginator;

    public QueryFilter $filter;

    protected function fromRequest(Request $request): static
    {
        $this->paginator = PaginatorHttpQueryParams::makeFromRequest($request);
        $this->filter = QueryFilter::makeFromRequest($request);

        return $this;
    }

    protected function fromArray(array $data): static
    {
        $this->paginator = PaginatorHttpQueryParams::makeFromArray($data);
        $this->filter = QueryFilter::makeFromArray($data);

        return $this;
    }

}
