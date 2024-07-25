<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Application\Manager\Commands\Create;

use Project\Domains\Admin\Manager\Domain\Manager\Manager;
use Project\Domains\Admin\Manager\Domain\Manager\ManagerRepositoryInterface;
use Project\Domains\Admin\Manager\Domain\Manager\Services\Avatar\Contracts\AvatarServiceInterface;
use Project\Domains\Admin\Manager\Domain\Manager\ValueObjects\Email;
use Project\Domains\Admin\Manager\Domain\Manager\ValueObjects\FirstName;
use Project\Domains\Admin\Manager\Domain\Manager\ValueObjects\FullName;
use Project\Domains\Admin\Manager\Domain\Manager\ValueObjects\LastName;
use Project\Domains\Admin\Manager\Domain\Manager\ValueObjects\Password;
use Project\Domains\Admin\Manager\Domain\Manager\ValueObjects\Uuid;
use Project\Domains\Admin\Manager\Domain\Role\Exceptions\RoleNotFoundDomainException;
use Project\Domains\Admin\Manager\Domain\Role\ValueObjects\Uuid as RoleUuid;
use Project\Domains\Admin\Manager\Domain\Role\RoleRepositoryInterface;
use Project\Infrastructure\Generators\Contracts\TokenGeneratorInterface;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\Bus\Event\EventBusInterface;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private ManagerRepositoryInterface $repository,
        private TokenGeneratorInterface $tokenGenerator,
        private AvatarServiceInterface $avatarService,
        private RoleRepositoryInterface $roleRepository,
        private EventBusInterface $eventBus
    ) { }

    public function __invoke(Command $command): void
    {
        $role = $this->roleRepository->findByUuid(RoleUuid::fromValue($command->roleUuid));

        $role ?? throw new RoleNotFoundDomainException();

        $manager = Manager::create(
            Uuid::fromValue($command->uuid),
            FullName::make(
                FirstName::fromValue($command->firstName),
                LastName::fromValue($command->lastName)
            ),
            Email::fromValue($command->email),
            Password::fromValue($this->tokenGenerator->generate(Password::LENGTH)),
            $role
        );

        $this->avatarService->upload($manager, $command->avatar);

        $this->repository->save($manager);
        $this->eventBus->publish(...$manager->pullDomainEvents());
    }
}
