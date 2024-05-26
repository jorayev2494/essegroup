<?php

declare(strict_types=1);

namespace Project\Domains\Student\University\Application\Department\Queries\Index;

use Project\Domains\Student\University\Domain\Department\Services\Contracts\DepartmentServiceInterface;
use Project\Infrastructure\Services\Auth\AuthManager;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private DepartmentServiceInterface $service
    ) { }

    public function __invoke(Query $query): array
    {
        return $this->service->index(AuthManager::companyUuid(), $query);
    }
}
