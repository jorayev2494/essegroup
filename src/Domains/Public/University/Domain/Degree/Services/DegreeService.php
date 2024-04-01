<?php

declare(strict_types=1);

namespace Project\Domains\Public\University\Domain\Degree\Services;

use Project\Domains\Public\University\Application\Degree\Queries\List\Query;
use Project\Domains\Public\University\Domain\Degree\Services\Contracts\DegreeServiceInterface;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;
use Project\Domains\Admin\University\Application\Degree\Queries\List\Query as ListQuery;

readonly class DegreeService implements DegreeServiceInterface
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
