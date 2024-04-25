<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Company\Application\Employee\Queries\Index;

use Project\Domains\Admin\Company\Domain\Employee\EmployeeRepositoryInterface;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private EmployeeRepositoryInterface $repository
    ) { }

    public function __invoke(Query $query): array
    {
        return $this->repository->paginate($query)->toArray();
    }
}
