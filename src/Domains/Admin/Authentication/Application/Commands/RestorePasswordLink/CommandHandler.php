<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Application\Commands\RestorePasswordLink;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Admin\Authentication\Domain\Code\Code;
use Project\Domains\Admin\Authentication\Domain\Member\MemberRepositoryInterface;
use Project\Domains\Admin\Authentication\Domain\Member\ValueObjects\Email;
use Project\Infrastructure\Generators\Contracts\TokenGeneratorInterface;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;

readonly class CommandHandler implements CommandHandlerInterface
{
    function __construct(
        private MemberRepositoryInterface $repository,
        private TokenGeneratorInterface $tokenGenerator,
    )
    {

    }

    public function __invoke(Command $command): void
    {
        $member = $this->repository->findByEmail(Email::fromValue($command->email));

        if ($member === null) {
            throw new ModelNotFoundException();
        }

        if ($member->hasCode()) {
            $member->removeCode();
            $this->repository->save($member);
        }

        $code = Code::fromPrimitives(
            $this->tokenGenerator->generate(),
            new \DateTimeImmutable('+ 1 hour')
        );

        $member->addCode($code);
        $this->repository->save($member);
    }
}
