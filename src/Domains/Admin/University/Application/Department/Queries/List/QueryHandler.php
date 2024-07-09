<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\Department\Queries\List;

use Project\Domains\Admin\University\Domain\Department\DepartmentRepositoryInterface;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private DepartmentRepositoryInterface $departmentRepository
    )
    {

    }

    public function __invoke(Query $query): array
    {
        return $this->departmentRepository->list($query->filter)
            ->translateItems()
            ->toArray();
    }
}
