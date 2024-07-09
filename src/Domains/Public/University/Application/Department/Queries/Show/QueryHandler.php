<?php

declare(strict_types=1);

namespace Project\Domains\Public\University\Application\Department\Queries\Show;

use Project\Domains\Public\University\Domain\Department\Services\Contracts\DepartmentServiceInterface;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private DepartmentServiceInterface $departmentService
    ) { }

    public function __invoke(Query $query): array
    {
        return $this->departmentService->show($query->uuid);
    }
}
