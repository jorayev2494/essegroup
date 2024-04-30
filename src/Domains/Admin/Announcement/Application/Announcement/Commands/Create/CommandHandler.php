<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Announcement\Application\Announcement\Commands\Create;

use Project\Domains\Admin\Announcement\Domain\Announcement\Announcement;
use Project\Domains\Admin\Announcement\Domain\Announcement\AnnouncementRepositoryInterface;
use Project\Domains\Admin\Announcement\Domain\Announcement\ValueObjects\ForItemEnum;
use Project\Domains\Admin\Announcement\Domain\Announcement\ValueObjects\Uuid;
use Project\Infrastructure\Services\Auth\AuthManager;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\Translation\TranslationColumnServiceInterface;
use DateTimeImmutable;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private AnnouncementRepositoryInterface $repository,
        private TranslationColumnServiceInterface $translationColumnService
    ) { }

    public function __invoke(Command $command): void
    {
        $announcement = Announcement::create(
            Uuid::fromValue($command->uuid),
            ForItemEnum::from($command->for),
            new DateTimeImmutable($command->startTime),
            AuthManager::manager(),
            $command->isActive
        );

        if ($command->endTime !== null) {
            $announcement->setEndTime(new DateTimeImmutable($command->endTime));
        }

        $this->translationColumnService->addTranslations($announcement, $command->translations);

        $this->repository->save($announcement);
    }
}
