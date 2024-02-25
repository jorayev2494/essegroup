<?php

declare(strict_types=1);

namespace Project\Domains\Public\University\Domain\Country\Services;

use Project\Domains\Admin\University\Infrastructure\Country\Filters\HttpQueryFilterDTO;
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

    public function list(HttpQueryFilterDTO $queryFilterDTO): array
    {
        return $this->queryBus->ask(Query::makeFromArray($queryFilterDTO->toArray()));
    }
}
