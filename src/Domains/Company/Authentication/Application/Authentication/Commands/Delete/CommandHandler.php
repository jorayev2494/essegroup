<?php

declare(strict_types=1);

namespace Project\Domains\Company\Authentication\Application\Authentication\Commands\Delete;

//use Project\Domains\Company\Authentication\Domain\Member\Member;
//use Project\Domains\Company\Authentication\Domain\Member\MemberRepositoryInterface;
//use Project\Domains\Company\Authentication\Domain\Member\ValueObjects\Uuid;
use Project\Infrastructure\Hashers\Contracts\PasswordHasherInterface;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
//        private MemberRepositoryInterface $repository
    )
    {

    }

    public function __invoke(Command $command): void
    {
//        $member = $this->repository->findByUuid(Uuid::fromValue($command->uuid));
//
//        if ($member === null) {
//            return;
//        }
//
//        $this->repository->save($member);
    }
}
