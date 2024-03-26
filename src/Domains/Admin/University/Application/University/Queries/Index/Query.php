<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\University\Queries\Index;

use Project\Domains\Admin\University\Infrastructure\University\Filters\QueryFilter;
use Project\Shared\Domain\Bus\Query\BaseHttpQueryParams;
use Project\Shared\Infrastructure\Repository\Doctrine\PaginatorHttpQueryParams;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

readonly class Query extends BaseHttpQueryParams
{
    public PaginatorHttpQueryParams $paginator;

    public QueryFilter $filter;

    protected function fromRequest(SymfonyRequest $request): static
    {
        $this->paginator = PaginatorHttpQueryParams::makeFromRequest($request);
        $this->filter = QueryFilter::makeFromRequest($request);

        return $this;
    }

    protected function fromArray(array $data): static
    {
        $this->filter = QueryFilter::makeFromArray($data);

        return $this;
    }

    public function toArray(): array
    {
        return [
            ...$this->filter->toArray(),
        ];
    }
}
