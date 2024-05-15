<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Contest\Domain\Contest\Services\Contracts;

use Project\Domains\Admin\Contest\Domain\Contest\Contest;

interface ContestServiceInterface
{
    public function setApplicationStatuses(Contest $contest, array $applicationStatusUuids): void;

    public function setStudentNationalityUuids(Contest $contest, array $studentNationalityUuids): void;

    public function setParticipantsNumber(Contest $contest, int $participantsNumber): void;
}
