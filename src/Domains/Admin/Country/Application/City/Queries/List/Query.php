<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Country\Application\City\Queries\List;

use Project\Domains\Admin\Country\Infrastructure\City\Filters\QueryFilter;
use Project\Shared\Domain\Bus\Query\BaseHttpQueryParams;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

readonly class Query extends BaseHttpQueryParams
{
    public QueryFilter $filter;

    public function fromRequest(SymfonyRequest $request): static
    {
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
