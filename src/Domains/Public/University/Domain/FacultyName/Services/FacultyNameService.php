<?php

declare(strict_types=1);

namespace Project\Domains\Public\University\Domain\FacultyName\Services;

use Project\Domains\Public\University\Application\FacultyName\Queries\List\Query;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;
use Project\Domains\Admin\University\Application\Faculty\Name\Queries\List\Query as QueriesList;

class FacultyNameService implements Contracts\FacultyNameServiceInterface
{
    public function list(Query $query): array
    {
        /** @var QueryBusInterface $queryBus */
        $queryBus = resolve(QueryBusInterface::class);

        return $queryBus->ask(QueriesList::makeFromArray($query->toArray()));
    }
}
