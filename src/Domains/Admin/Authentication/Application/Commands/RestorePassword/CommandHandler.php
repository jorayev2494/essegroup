<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Application\Commands\RestorePassword;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Admin\Authentication\Domain\Code\CodeRepositoryInterface;
use Project\Domains\Admin\Authentication\Domain\Member\MemberRepositoryInterface;
use Project\Domains\Admin\Authentication\Domain\Member\ValueObjects\Password;
use Project\Infrastructure\Hashers\Contracts\PasswordHasherInterface;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;

readonly class CommandHandler implements CommandHandlerInterface
{
    function __construct(
        private MemberRepositoryInterface $repository,
        private CodeRepositoryInterface $codeRepository,
        private PasswordHasherInterface $passwordHasher,
    )
    {

    }

    public function __invoke(Command $command): void
    {
        $foundCode = $this->codeRepository->findByToken($command->token);

        if ($foundCode === null) {
            throw new ModelNotFoundException();
        }

        $member = $foundCode->getAuthor();
        $member->changePassword(Password::fromValue($this->passwordHasher->hash($command->password)));
        $member->removeCode();

        $this->repository->save($member);
    }
}
