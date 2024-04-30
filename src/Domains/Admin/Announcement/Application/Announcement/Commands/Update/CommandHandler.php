<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Announcement\Application\Announcement\Commands\Update;

use DateTimeImmutable;
use Project\Domains\Admin\Announcement\Domain\Announcement\AnnouncementRepositoryInterface;
use Project\Domains\Admin\Announcement\Domain\Announcement\Exceptions\AnnouncementNotFoundDomainException;
use Project\Domains\Admin\Announcement\Domain\Announcement\ValueObjects\ForItemEnum;
use Project\Domains\Admin\Announcement\Domain\Announcement\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\Translation\TranslationColumnServiceInterface;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private AnnouncementRepositoryInterface $repository,
        private TranslationColumnServiceInterface $translationColumnService
    ) { }

    public function __invoke(Command $command): void
    {
        $announcement = $this->repository->findByUuid(Uuid::fromValue($command->uuid));

        $announcement ?? throw new AnnouncementNotFoundDomainException();

        $announcement->changeForItem(ForItemEnum::from($command->for));
        $announcement->changeStartTime(new DateTimeImmutable($command->startTime));
        $announcement->changeIsActive($command->isActive);

        if ($command->endTime !== null) {
            $announcement->changeEndTime(new DateTimeImmutable($command->endTime));
        } else {
            $announcement->changeEndTime($command->endTime);
        }

        $this->translationColumnService->addTranslations($announcement, $command->translations);

        $this->repository->save($announcement);
    }
}
