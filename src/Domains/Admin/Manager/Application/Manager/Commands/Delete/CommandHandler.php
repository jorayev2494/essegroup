<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Application\Manager\Commands\Delete;

use Project\Domains\Admin\Manager\Domain\Manager\Exceptions\ManagerNotFoundDomainException;
use Project\Domains\Admin\Manager\Domain\Manager\ManagerRepositoryInterface;
use Project\Domains\Admin\Manager\Domain\Manager\Services\Avatar\Contracts\AvatarServiceInterface;
use Project\Domains\Admin\Manager\Domain\Manager\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private ManagerRepositoryInterface $repository,
        private AvatarServiceInterface $avatarService
    ) { }

    public function __invoke(Command $command): void
    {
        $manager = $this->repository->findByUuid(Uuid::fromValue($command->uuid));

        $manager ?? throw new ManagerNotFoundDomainException();

        $this->avatarService->delete($manager);

        $this->repository->delete($manager);
    }
}