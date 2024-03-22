<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\University\Queries\List;

use Project\Domains\Admin\University\Infrastructure\University\Filters\QueryFilter;
use Project\Shared\Domain\Bus\Query\BaseHttpQueryParams;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

readonly class Query extends BaseHttpQueryParams
{
    public QueryFilter $httpQueryFilter;

    protected function fromRequest(SymfonyRequest $request): static
    {
        $this->httpQueryFilter = QueryFilter::makeFromRequest($request);

        return $this;
    }

    protected function fromArray(array $data): static
    {
        $this->httpQueryFilter = QueryFilter::makeFromArray($data);

        return $this;
    }
}
