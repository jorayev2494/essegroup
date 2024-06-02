<?php

declare(strict_types=1);

namespace Project\Domains\Student\Profile\Application\Profile\Commands\ChangePassword;

use Project\Domains\Admin\Student\Domain\Student\StudentRepositoryInterface;
use Project\Domains\Admin\Student\Domain\Student\ValueObjects\Password;
use Project\Infrastructure\Hashers\Contracts\PasswordHasherInterface;
use Project\Infrastructure\Services\Auth\AuthManager;
use Project\Infrastructure\Services\Authentication\Events\CurrentPasswordIsInvalidDomainEvent;
use Project\Shared\Domain\Bus\Command\CommandInterface;

readonly class CommandHandler implements CommandInterface
{
    public function __construct(
        private StudentRepositoryInterface $repository,
        private PasswordHasherInterface $passwordHasher
    ) { }

    public function __invoke(Command $command): void
    {
        $student = AuthManager::student();

        if (! $this->passwordHasher->check($command->currentPassword, $student->getPassword())) {
            throw new CurrentPasswordIsInvalidDomainEvent();
        }

        $student->setPassword(Password::fromValue($this->passwordHasher->hash($command->newPassword)));

        $this->repository->save($student);
    }
}
