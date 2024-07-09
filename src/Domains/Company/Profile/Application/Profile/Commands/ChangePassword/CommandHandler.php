<?php

declare(strict_types=1);

namespace Project\Domains\Company\Profile\Application\Profile\Commands\ChangePassword;

use Project\Domains\Admin\Company\Domain\Employee\EmployeeRepositoryInterface;
use Project\Domains\Admin\Company\Domain\Employee\ValueObjects\Password;
use Project\Infrastructure\Hashers\Contracts\PasswordHasherInterface;
use Project\Infrastructure\Services\Auth\AuthManager;
use Project\Infrastructure\Services\Authentication\Events\CurrentPasswordIsInvalidDomainEvent;
use Project\Shared\Domain\Bus\Command\CommandInterface;

readonly class CommandHandler implements CommandInterface
{
    public function __construct(
        private EmployeeRepositoryInterface $repository,
        private PasswordHasherInterface $passwordHasher
    ) { }

    public function __invoke(Command $command): void
    {
        $employee = AuthManager::employee();

        if (! $this->passwordHasher->check($command->currentPassword, $employee->getPassword())) {
            throw new CurrentPasswordIsInvalidDomainEvent();
        }

        $employee->setPassword(Password::fromValue($this->passwordHasher->hash($command->newPassword)));

        $this->repository->save($employee);
    }
}
