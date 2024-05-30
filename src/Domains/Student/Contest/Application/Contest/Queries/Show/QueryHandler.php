<?php

declare(strict_types=1);

namespace Project\Domains\Student\Contest\Application\Contest\Queries\Show;

use Project\Domains\Student\Contest\Domain\Contest\Services\Contracts\ContestServiceInterface;
use Project\Infrastructure\Services\Auth\AuthManager;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;
use Project\Shared\Domain\ValueObject\UuidValueObject;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private ContestServiceInterface $service
    ) { }

    public function __invoke(Query $query): array
    {
        return $this->service->show(AuthManager::studentUuid(), UuidValueObject::fromValue($query->uuid));
    }
}
