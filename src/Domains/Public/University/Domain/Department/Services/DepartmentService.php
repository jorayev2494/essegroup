<?php

declare(strict_types=1);

namespace Project\Domains\Public\University\Domain\Department\Services;

use Project\Domains\Admin\University\Application\Department\Queries\List\Query;
use Project\Domains\Public\University\Domain\Department\Services\Contracts\DepartmentServiceInterface;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;
use Project\Domains\Admin\University\Infrastructure\Department\Filters\HttpQueryFilterDTO;

readonly class DepartmentService implements DepartmentServiceInterface
{
    public function __construct(
        private QueryBusInterface $queryBus
    )
    {

    }

    public function list(HttpQueryFilterDTO $httpQueryFilterDTO): array
    {
        return $this->queryBus->ask(
            Query::makeFromArray($httpQueryFilterDTO->toArray())
        );
    }
}
