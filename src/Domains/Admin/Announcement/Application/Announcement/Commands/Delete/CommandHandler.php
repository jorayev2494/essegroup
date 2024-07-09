<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Announcement\Application\Announcement\Commands\Delete;

use Project\Domains\Admin\Announcement\Domain\Announcement\AnnouncementRepositoryInterface;
use Project\Domains\Admin\Announcement\Domain\Announcement\Exceptions\AnnouncementNotFoundDomainException;
use Project\Domains\Admin\Announcement\Domain\Announcement\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private AnnouncementRepositoryInterface $repository
    ) { }

    public function __invoke(Command $command): void
    {
        $announcement = $this->repository->findByUuid(Uuid::fromValue($command->uuid));

        $announcement ?? throw new AnnouncementNotFoundDomainException();

        $this->repository->delete($announcement);
    }
}
