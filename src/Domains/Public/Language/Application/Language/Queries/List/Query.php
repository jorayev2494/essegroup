<?php

declare(strict_types=1);

namespace Project\Domains\Public\Language\Application\Language\Queries\List;

use Project\Domains\Admin\Language\Infrastructure\Language\Filters\QueryFilter;
use Project\Shared\Domain\Bus\Query\BaseHttpQueryParams;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

readonly class Query extends BaseHttpQueryParams
{
    public QueryFilter $filter;

    protected function fromRequest(SymfonyRequest $request): static
    {
        $this->filter = QueryFilter::makeFromRequest($request);

        return $this;
    }

    protected function fromArray(array $data): static
    {
        return $this;
    }

    public function toArray(): array
    {
        return [
            ...$this->filter->toArray(),
        ];
    }
}
