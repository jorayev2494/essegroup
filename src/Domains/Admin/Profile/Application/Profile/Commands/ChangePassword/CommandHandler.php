<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Profile\Application\Profile\Commands\ChangePassword;

use Project\Domains\Admin\Manager\Domain\Manager\ManagerRepositoryInterface;
use Project\Domains\Admin\Manager\Domain\Manager\ValueObjects\Password;
use Project\Infrastructure\Hashers\Contracts\PasswordHasherInterface;
use Project\Infrastructure\Services\Auth\AuthManager;
use Project\Infrastructure\Services\Authentication\Events\CurrentPasswordIsInvalidDomainEvent;
use Project\Shared\Domain\Bus\Command\CommandInterface;

readonly class CommandHandler implements CommandInterface
{
    public function __construct(
        private ManagerRepositoryInterface $repository,
        private PasswordHasherInterface $passwordHasher
    ) { }

    public function __invoke(Command $command): void
    {
        $manager = AuthManager::manager();

        if (! $this->passwordHasher->check($command->currentPassword, $manager->getPassword())) {
            throw new CurrentPasswordIsInvalidDomainEvent();
        }

        $manager->setPassword(Password::fromValue($this->passwordHasher->hash($command->newPassword)));

        $this->repository->save($manager);
    }
}
