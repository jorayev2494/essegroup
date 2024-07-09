<?php

namespace Project\Domains\Public\University\Domain\Alias\Services;

use Project\Domains\Public\University\Application\Alias\Queries\List\Query;
use Project\Domains\Public\University\Domain\Alias\Services\Contracts\AliasServiceInterface;
use Project\Domains\Admin\University\Application\Alias\Queries\List\Query as ListQuery;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;

readonly class AliasService implements AliasServiceInterface
{
    public function list(Query $query): array
    {
        /** @var QueryBusInterface $queryBus */
        $queryBus = resolve(QueryBusInterface::class);

        return $queryBus->ask(ListQuery::makeFromArray($query->toArray()));
    }
}
