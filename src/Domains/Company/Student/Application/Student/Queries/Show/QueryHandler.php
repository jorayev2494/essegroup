<?php

declare(strict_types=1);

namespace Project\Domains\Company\Student\Application\Student\Queries\Show;

use Project\Domains\Company\Student\Domain\Student\Services\Contracts\StudentServiceInterface;
use Project\Infrastructure\Services\Auth\AuthManager;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;
use Project\Shared\Domain\ValueObject\UuidValueObject;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private StudentServiceInterface $service
    ) { }

    public function __invoke(Query $query): array
    {
        return $this->service->show(AuthManager::companyUuid(), UuidValueObject::fromValue($query->uuid));
    }
}
