<?php

declare(strict_types=1);

namespace Project\Domains\Student\University\Domain\ApplicationStatusValue\Services;

use Project\Domains\Student\University\Application\ApplicationStatusValue\Queries\List\Query;
use Project\Domains\Student\University\Domain\ApplicationStatusValue\Services\Contracts\ApplicationStatusValueServiceInterface;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;

readonly class ApplicationStatusValueService implements ApplicationStatusValueServiceInterface
{
    public function list(Query $query): array
    {
        /** @var QueryBusInterface $queryBus */
        $queryBus = resolve(QueryBusInterface::class);

        return $queryBus->ask(
            new \Project\Domains\Admin\University\Application\ApplicationStatusValue\Queries\List\Query()
        );
    }
}
