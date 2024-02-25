<?php

declare(strict_types=1);

namespace Project\Domains\Public\University\Application\Department\Queries\List;

use Project\Domains\Admin\University\Infrastructure\Department\Filters\HttpQueryFilterDTO;
use Project\Shared\Domain\Bus\Query\BaseHttpQueryParams;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

readonly class Query extends BaseHttpQueryParams
{
    public HttpQueryFilterDTO $httpQueryFilter;

    protected function fromRequest(SymfonyRequest $request): static
    {
        $this->httpQueryFilter = HttpQueryFilterDTO::makeFromRequest($request);

        return $this;
    }
}
