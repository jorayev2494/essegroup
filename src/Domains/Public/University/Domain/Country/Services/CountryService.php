<?php

declare(strict_types=1);

namespace Project\Domains\Public\University\Domain\Country\Services;

use Project\Domains\Admin\University\Infrastructure\Country\Filters\QueryFilter;
use Project\Domains\Admin\University\Application\Country\Queries\List\Query;
use Project\Domains\Public\University\Domain\Country\Services\Contracts\CountryServiceInterface;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;

readonly class CountryService implements CountryServiceInterface
{
    public function __construct(
        private QueryBusInterface $queryBus
    )
    {

    }

    public function list(QueryFilter $queryFilter): array
    {
        return $this->queryBus->ask(Query::makeFromArray($queryFilter->toArray()));
    }
}
