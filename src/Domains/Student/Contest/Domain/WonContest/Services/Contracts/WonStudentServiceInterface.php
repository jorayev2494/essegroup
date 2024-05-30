<?php

declare(strict_types=1);

namespace Project\Domains\Student\Contest\Domain\WonContest\Services\Contracts;

use Project\Shared\Domain\ValueObject\UuidValueObject;

interface WonStudentServiceInterface
{
    public function showContestStudent(UuidValueObject $studentUuid, UuidValueObject $contestUuid): array;
}
