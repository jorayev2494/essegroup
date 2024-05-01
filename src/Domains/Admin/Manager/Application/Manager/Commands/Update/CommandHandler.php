<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Application\Manager\Commands\Update;

use Project\Domains\Admin\Manager\Domain\Manager\Exceptions\ManagerNotFoundDomainException;
use Project\Domains\Admin\Manager\Domain\Manager\ManagerRepositoryInterface;
use Project\Domains\Admin\Manager\Domain\Manager\Services\Avatar\Contracts\AvatarServiceInterface;
use Project\Domains\Admin\Manager\Domain\Manager\ValueObjects\Email;
use Project\Domains\Admin\Manager\Domain\Manager\ValueObjects\FirstName;
use Project\Domains\Admin\Manager\Domain\Manager\ValueObjects\LastName;
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

        $manager->getFullName()
            ->changeFirstName(FirstName::fromValue($command->firstName))
            ->changeLastName(LastName::fromValue($command->lastName));

        $manager->changeEmail(Email::fromValue($command->email));

        $this->avatarService->update($manager, $command->avatar);

        $this->repository->save($manager);
    }
}
