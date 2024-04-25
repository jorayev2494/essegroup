<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Company\Application\Employee\Queries\Show;

use Project\Domains\Admin\Company\Domain\Employee\EmployeeRepositoryInterface;
use Project\Domains\Admin\Company\Domain\Employee\Exceptions\EmployeeNotFoundDomainException;
use Project\Domains\Admin\Company\Domain\Employee\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private EmployeeRepositoryInterface $repository
    ) { }

    public function __invoke(Query $query): array
    {
        $employee = $this->repository->findByUuid(Uuid::fromValue($query->uuid));

        $employee ?? throw new EmployeeNotFoundDomainException();

        return $employee->toArray();
    }
}
