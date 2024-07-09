<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\DepartmentName\Queries\List;

use Project\Domains\Admin\University\Domain\Department\Name\DepartmentNameRepositoryInterface;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private DepartmentNameRepositoryInterface $nameRepository
    ) {

    }

    public function __invoke(Query $query): array
    {
        return $this->nameRepository->list()
            ->translateItems()
            ->toArray();
    }
}
