<?php

namespace Project\Domains\Admin\University\Application\Country\Queries\List;

use Project\Domains\Admin\University\Infrastructure\Country\Filters\HttpQueryFilterDTO;
use Project\Shared\Domain\Bus\Query\BaseHttpQueryParams;
use Symfony\Component\HttpFoundation\Request;

readonly class Query extends BaseHttpQueryParams
{
    public HttpQueryFilterDTO $httpQueryFilter;

    protected function fromRequest(Request $request): static
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
