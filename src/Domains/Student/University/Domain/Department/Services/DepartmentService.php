<?php

declare(strict_types=1);

namespace Project\Domains\Student\University\Domain\Department\Services;

use Project\Domains\Student\University\Application\Department\Queries\Index\Query;
use Project\Domains\Student\University\Domain\Department\Services\Contracts\DepartmentServiceInterface;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;
use Project\Shared\Domain\ValueObject\UuidValueObject;

class DepartmentService implements DepartmentServiceInterface
{
    public function index(UuidValueObject $companyUuid, Query $query): array
    {
        /** @var QueryBusInterface $queryBus */
        $queryBus = resolve(QueryBusInterface::class);

        return $queryBus->ask(
            \Project\Domains\Admin\University\Application\Department\Queries\Index\Query::makeFromArray($query->toArray())
        );
    }
}
