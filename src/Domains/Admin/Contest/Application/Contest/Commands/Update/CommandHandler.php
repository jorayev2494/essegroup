<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Contest\Application\Contest\Commands\Update;

use Project\Domains\Admin\Contest\Domain\Contest\ContestRepositoryInterface;
use Project\Domains\Admin\Contest\Domain\Contest\Exceptions\ContestNotFoundDomainException;
use Project\Domains\Admin\Contest\Domain\Contest\Services\Contracts\ContestServiceInterface;
use Project\Domains\Admin\Contest\Domain\Contest\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use DateTimeImmutable;
use Project\Shared\Domain\Translation\TranslationColumnServiceInterface;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private ContestRepositoryInterface $repository,
        private ContestServiceInterface $service,
        private TranslationColumnServiceInterface $translationColumnService
    ) { }

    public function __invoke(Command $command): void
    {
        $contest = $this->repository->findByUuid(Uuid::fromValue($command->uuid));

        $contest ?? throw new ContestNotFoundDomainException();

        $contest->setStartTime(new DateTimeImmutable($command->startTime));

        if ($command->endTime !== null) {
            $contest->setEndTime(new DateTimeImmutable($command->endTime));
        } else {
            $contest->setEndTime(null);
        }

        $this->translationColumnService->addTranslations($contest, $command->translations);

        $this->service->setApplicationStatuses($contest, $command->applicationStatusUuids);
        $this->service->setStudentNationalityUuids($contest, $command->studentNationalityUuids);
        $this->service->setParticipantsNumber($contest, $command->participantsNumber);
        $contest->setIsActive($command->isActive);

        $this->repository->save($contest);
    }
}
