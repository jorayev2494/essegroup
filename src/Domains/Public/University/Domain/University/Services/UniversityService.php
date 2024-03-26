<?php

declare(strict_types=1);

namespace Project\Domains\Public\University\Domain\University\Services;

use Project\Domains\Admin\University\Application\University\Queries\Search\Query;
use Project\Domains\Public\University\Application\University\Queries\List\Query as ListQuery;
use Project\Domains\Public\University\Domain\University\Services\Contracts\UniversityServiceInterface;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;
use Project\Domains\Public\University\Application\University\Queries\Search\Query as SearchQuery;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

readonly class UniversityService implements UniversityServiceInterface
{
    public function __construct(

    )
    {

    }

    public function list(ListQuery $query): array
    {
        // return $this->queryBus->ask(new \Project\Domains\Admin\University\Application\University\Queries\List\QueryHandler())
    }

    public function search(SearchQuery $query): array
    {
        /** @var QueryBusInterface $queryBus */
        $queryBus = resolve(QueryBusInterface::class);

        return $queryBus->ask(Query::makeFromArray($query->toArray()));
    }
}
