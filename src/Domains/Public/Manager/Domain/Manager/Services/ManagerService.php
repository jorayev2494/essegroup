<?php

declare(strict_types=1);

namespace Project\Domains\Public\Manager\Domain\Manager\Services;

use Project\Domains\Public\Manager\Domain\Manager\Services\Contracts\ManagerServiceInterface;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;
use Project\Domains\Admin\Manager\Application\Manager\Queries\List\Query as ListQuery;
use Project\Domains\Admin\Manager\Application\Manager\Queries\Show\Query as ShowQuery;

readonly class ManagerService implements ManagerServiceInterface
{
    public function list(): array
    {
        /** @var QueryBusInterface $queryBus */
        $queryBus = resolve(QueryBusInterface::class);

        return $queryBus->ask(
            ListQuery::makeFromArray([])
        );
    }

    public function show(string $uuid): array
    {
        /** @var QueryBusInterface $queryBus */
        $queryBus = resolve(QueryBusInterface::class);

        return $queryBus->ask(
            new ShowQuery($uuid)
        );
    }
}
