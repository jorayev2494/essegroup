<?php

declare(strict_types=1);

namespace Project\Domains\Company\Employee\Application\Employee\Queries\Show;

use Project\Domains\Company\Employee\Domain\Employee\Services\Contracts\EmployeeServiceInterface;
use Project\Infrastructure\Services\Auth\AuthManager;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;
use Project\Shared\Domain\ValueObject\UuidValueObject;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private EmployeeServiceInterface $service
    ) { }

    public function __invoke(Query $query): array
    {
        return $this->service->show(
            AuthManager::companyUuid(),
            UuidValueObject::fromValue($query->uuid)
        );
    }
}
