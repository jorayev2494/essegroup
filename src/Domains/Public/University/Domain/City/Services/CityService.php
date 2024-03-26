<?php

declare(strict_types=1);

namespace Project\Domains\Public\University\Domain\City\Services;

use Project\Domains\Public\University\Application\City\Queries\List\Query;
use Project\Domains\Public\University\Domain\City\Services\Contracts\CityServiceInterface;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;
use Project\Domains\Admin\Country\Application\City\Queries\List\Query as ListQuery;

readonly class CityService implements CityServiceInterface
{
    public function __construct(

    ) {

    }

    public function list(Query $query): array
    {
        /** @var QueryBusInterface $queryBus */
        $queryBus = resolve(QueryBusInterface::class);

        return $queryBus->ask(ListQuery::makeFromArray($query->toArray()));
    }
}
