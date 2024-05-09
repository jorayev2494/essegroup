<?php

declare(strict_types=1);

namespace Project\Domains\Public\University\Domain\Department\Services;

use Project\Domains\Public\University\Domain\Department\Services\Contracts\DepartmentServiceInterface;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;
use Project\Domains\Admin\University\Infrastructure\Department\Filters\QueryFilter;
use Project\Domains\Public\University\Application\Department\Queries\Index\Query as IndexQuery;

readonly class DepartmentService implements DepartmentServiceInterface
{
    public function index(IndexQuery $query): array
    {
        /** @var QueryBusInterface $queryBus */
        $queryBus = resolve(QueryBusInterface::class);

        return $queryBus->ask(
            \Project\Domains\Admin\University\Application\Department\Queries\Index\Query::makeFromArray($query->toArray())
        );
    }

    public function list(QueryFilter $queryFilter): array
    {
        /** @var QueryBusInterface $queryBus */
        $queryBus = resolve(QueryBusInterface::class);

        return $queryBus->ask(
            \Project\Domains\Admin\University\Application\Department\Queries\List\Query::makeFromArray($queryFilter->toArray())
        );
    }
}
