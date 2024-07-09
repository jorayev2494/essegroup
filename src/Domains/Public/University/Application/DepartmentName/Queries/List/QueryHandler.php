<?php

declare(strict_types=1);

namespace Project\Domains\Public\University\Application\DepartmentName\Queries\List;

use Project\Domains\Public\University\Domain\DepartmentName\Services\Contracts\DepartmentNameServiceInterface;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private DepartmentNameServiceInterface $departmentNameService
    ) {

    }

    public function __invoke(Query $query): array
    {
        return $this->departmentNameService->list($query);
    }
}
