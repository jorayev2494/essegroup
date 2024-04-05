<?php

declare(strict_types=1);

namespace Project\Domains\Public\University\Domain\DepartmentName\Services;

use Project\Domains\Public\University\Application\DepartmentName\Queries\List\Query;
use Project\Domains\Public\University\Domain\DepartmentName\Services\Contracts\DepartmentNameServiceInterface;
use Project\Domains\Admin\University\Application\DepartmentName\Queries\List\Query as ListQuery;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;

class DepartmentNameService implements DepartmentNameServiceInterface
{
    public function list(Query $query): array
    {
        /** @var QueryBusInterface $queryBus */
        $queryBus = resolve(QueryBusInterface::class);

        return $queryBus->ask(ListQuery::makeFromArray($query->toArray()));
    }
}
