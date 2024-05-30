<?php

declare(strict_types=1);

namespace Project\Domains\Student\Contest\Domain\WonContest\Services;

use Project\Domains\Student\Contest\Domain\WonContest\Services\Contracts\WonStudentServiceInterface;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;
use Project\Domains\Admin\Contest\Application\WonStudent\Queries\GetByContestAndStudent\Query as GetByContestAndStudentQuery;
use Project\Shared\Domain\ValueObject\UuidValueObject;

readonly class WonStudentService implements WonStudentServiceInterface
{
    public function showContestStudent(UuidValueObject $studentUuid, UuidValueObject $contestUuid): array
    {
        /** @var QueryBusInterface $queryBus */
        $queryBus = resolve(QueryBusInterface::class);

        return $queryBus->ask(
            new GetByContestAndStudentQuery(
                $contestUuid->value,
                $studentUuid->value
            )
        );
    }
}
