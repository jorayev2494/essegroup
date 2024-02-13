<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\Department\Queries\Index;

use Project\Domains\Admin\University\Domain\Department\DepartmentRepositoryInterface;
use Project\Domains\Admin\University\Domain\Department\DepartmentTranslate;
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
        return $this->departmentRepository->paginate($query)
            ->translateItems(DepartmentTranslate::class)
            ->toArray();
    }
}
