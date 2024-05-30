<?php

declare(strict_types=1);

namespace Project\Domains\Student\Contest\Application\WonStudent\Queries\GetByContestAndStudent;

use Project\Domains\Student\Contest\Domain\WonContest\Services\Contracts\WonStudentServiceInterface;
use Project\Infrastructure\Services\Auth\AuthManager;
use Project\Shared\Domain\ValueObject\UuidValueObject;

readonly class QueryHandler
{
    public function __construct(
        private WonStudentServiceInterface $service
    ) { }

    public function __invoke(Query $query): array
    {
        return $this->service->showContestStudent(
            AuthManager::studentUuid(),
            UuidValueObject::fromValue($query->contestUuid)
        );
    }
}
