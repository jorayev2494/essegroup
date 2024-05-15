<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Contest\Application\Contest\Commands\Create;

use Project\Domains\Admin\Contest\Domain\Contest\Contest;
use Project\Domains\Admin\Contest\Domain\Contest\ContestRepositoryInterface;
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
        $contest = Contest::create(
            Uuid::fromValue($command->uuid),
            $command->participantsNumber,
            new DateTimeImmutable($command->startTime)
        );

        if ($command->endTime !== null) {
            $contest->setEndTime(new DateTimeImmutable($command->endTime));
        }

        $this->translationColumnService->addTranslations($contest, $command->translations);

        $this->service->setApplicationStatuses($contest, $command->applicationStatusUuids);
        $this->service->setStudentNationalityUuids($contest, $command->studentNationalityUuids);
        $this->service->setParticipantsNumber($contest, $command->participantsNumber);

        $this->repository->save($contest);
    }
}
