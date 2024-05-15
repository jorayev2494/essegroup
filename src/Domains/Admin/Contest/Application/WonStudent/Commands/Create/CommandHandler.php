<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Contest\Application\WonStudent\Commands\Create;

use Project\Domains\Admin\Contest\Domain\Contest\ContestRepositoryInterface;
use Project\Domains\Admin\Contest\Domain\Contest\Exceptions\ContestNotFoundDomainException;
use Project\Domains\Admin\Contest\Domain\Contest\ValueObjects\Uuid;
use Project\Domains\Admin\Contest\Domain\WonStudent\Exceptions\WonStudentNotFoundDomainException;
use Project\Domains\Admin\Contest\Domain\WonStudent\WonStudent;
use Project\Domains\Admin\Contest\Domain\WonStudent\WonStudentRepositoryInterface;
use Project\Domains\Admin\Country\Domain\Country\Country;
use Project\Domains\Admin\Student\Domain\Student\StudentRepositoryInterface;
use Project\Domains\Admin\University\Domain\Application\StatusValue;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private ContestRepositoryInterface $repository,
        private WonStudentRepositoryInterface $wonStudentRepository,
        private StudentRepositoryInterface $studentRepository
    ) { }

    public function __invoke(Command $command): array
    {
        $contest = $this->repository->findByUuid(Uuid::fromValue($command->uuid));

        $contest ?? throw new ContestNotFoundDomainException();

        $applicationStatusUuids = $contest->getApplicationStatuses()->map(static fn (StatusValue $statusValue): string => $statusValue->getUuid()->value)->toArray();
        $studentNationalityUuids = $contest->getStudentNationalities()->map(static fn (Country $country): string => $country->getUuid()->value)->toArray();
        $wonStudentUuids = array_filter(
            array_map(
                static fn (WonStudent $wonStudent): ?string => $wonStudent->getStudent()->getUuid()->value,
                $contest->getWonStudents()
            )
        );

        $students = $this->studentRepository->getParticipants($applicationStatusUuids, $studentNationalityUuids, $wonStudentUuids);
        $winnerStudent = $students->getRandomFirst();

        $winnerStudent ?? throw new WonStudentNotFoundDomainException();

        $wonStudent = WonStudent::create($contest, $winnerStudent);

        $this->wonStudentRepository->save($wonStudent);

        return [
            'code' => $wonStudent->getCode()->value,
            'won_student' => [
                'uuid' => $wonStudent->getStudent()->getUuid()->value,
                'avatar' => $wonStudent->getStudent()->getAvatar()?->toArray(),
                ...$wonStudent->getStudent()->getFullName()->toArray(),
            ],
        ];
    }
}
