<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Contest\Application\WonStudent\Queries\GetByContestAndStudent;

use Project\Domains\Admin\Contest\Domain\WonStudent\Exceptions\WonStudentNotFoundDomainException;
use Project\Domains\Admin\Contest\Domain\WonStudent\WonStudentRepositoryInterface;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;
use Project\Domains\Admin\Contest\Domain\Contest\ValueObjects\Uuid as ContestUuid;
use Project\Domains\Admin\Student\Domain\Student\ValueObjects\Uuid as StudentUuid;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private WonStudentRepositoryInterface $repository
    ) { }

    public function __invoke(Query $query): array
    {
        $wonStudent = $this->repository->findContestStudent(
            ContestUuid::fromValue($query->contestUuid),
            StudentUuid::fromValue($query->studentUuid)
        );

        $wonStudent ?? throw new WonStudentNotFoundDomainException();

        return $wonStudent->toArray();
    }
}
