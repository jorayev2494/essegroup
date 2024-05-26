<?php

declare(strict_types=1);

namespace Project\Domains\Student\Authentication\Application\Authentication\Commands\RestorePassword;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Admin\Student\Domain\Student\StudentRepositoryInterface;
use Project\Domains\Admin\Student\Domain\Student\ValueObjects\Password;
use Project\Domains\Student\Authentication\Domain\Code\CodeRepositoryInterface;
use Project\Infrastructure\Hashers\Contracts\PasswordHasherInterface;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;

readonly class CommandHandler implements CommandHandlerInterface
{
    function __construct(
        private StudentRepositoryInterface $repository,
        private CodeRepositoryInterface $codeRepository,
        private PasswordHasherInterface $passwordHasher,
    ) { }

    public function __invoke(Command $command): void
    {
        $foundCode = $this->codeRepository->findByToken($command->token);

        if ($foundCode === null) {
            throw new ModelNotFoundException();
        }

        $employee = $foundCode->getAuthor();
        $employee->changePassword(Password::fromValue($this->passwordHasher->hash($command->password)));
        $employee->removeCode();

        $this->repository->save($employee);
    }
}
