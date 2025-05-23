<?php

declare(strict_types=1);

namespace Project\Domains\Public\University\Domain\University\Services;

use Project\Domains\Admin\University\Application\University\Queries\Search\Query;
use Project\Domains\Public\University\Application\University\Queries\Index\Query as IndexQuery;
use Project\Domains\Public\University\Application\University\Queries\List\Query as ListQuery;
use Project\Domains\Public\University\Domain\University\Services\Contracts\UniversityServiceInterface;
use Project\Domains\Public\University\Application\University\Queries\Search\Query as SearchQuery;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;

readonly class UniversityService implements UniversityServiceInterface
{
    public function index(IndexQuery $query): array
    {
        /** @var QueryBusInterface $queryBus */
        $queryBus = resolve(QueryBusInterface::class);

        return $queryBus->ask(\Project\Domains\Admin\University\Application\University\Queries\Index\Query::makeFromArray($query->toArray()));
    }

    public function list(ListQuery $query): array
    {
        /** @var QueryBusInterface $queryBus */
        $queryBus = resolve(QueryBusInterface::class);

        return $queryBus->ask(\Project\Domains\Admin\University\Application\University\Queries\List\Query::makeFromArray($query->toArray()));
    }

    public function search(SearchQuery $query): array
    {
        /** @var QueryBusInterface $queryBus */
        $queryBus = resolve(QueryBusInterface::class);

        return $queryBus->ask(Query::makeFromArray($query->toArray()));
    }
}
