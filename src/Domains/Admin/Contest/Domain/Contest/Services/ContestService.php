<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Contest\Domain\Contest\Services;

use Project\Domains\Admin\Contest\Domain\Contest\Contest;
use Project\Domains\Admin\Contest\Domain\Contest\Services\Contracts\ContestServiceInterface;
use Project\Domains\Admin\Country\Domain\Country\CountryRepositoryInterface;
use Project\Domains\Admin\University\Domain\Application\StatusValueRepositoryInterface;

readonly class ContestService implements ContestServiceInterface
{
    public function __construct(
        private StatusValueRepositoryInterface $applicationStatusRepository,
        private CountryRepositoryInterface $studentNationalityRepository
    ) { }

    public function setApplicationStatuses(Contest $contest, array $applicationStatusUuids): void
    {
        $statuses = $this->applicationStatusRepository->findManyByUuids($applicationStatusUuids);

        $contest->getApplicationStatuses()->clear();
        $statuses->forEach($contest->addApplicationStatus(...));
    }

    public function setStudentNationalityUuids(Contest $contest, array $studentNationalityUuids): void
    {
        $countries = $this->studentNationalityRepository->findManyByUuids($studentNationalityUuids);

        $contest->getStudentNationalities()->clear();
        $countries->forEach($contest->addStudentNationality(...));
    }

    public function setParticipantsNumber(Contest $contest, int $participantsNumber): void
    {
        $contest->changeParticipantsNumber($participantsNumber);
    }
}
