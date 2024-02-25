<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Country\Application\Country\Queries\List;

use Project\Domains\Admin\Country\Infrastructure\Country\Filters\HttpQueryFilterDTO;
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

    protected function fromArray(array $data): static
    {
        $this->httpQueryFilter = HttpQueryFilterDTO::makeFromArray($data);

        return $this;
    }
}
