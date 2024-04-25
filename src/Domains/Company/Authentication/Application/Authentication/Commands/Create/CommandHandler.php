<?php

declare(strict_types=1);

namespace Project\Domains\Company\Authentication\Application\Authentication\Commands\Create;

//use Project\Domains\Company\Authentication\Domain\Company\CompanyRepositoryInterface;
//use Project\Domains\Company\Authentication\Domain\Member\Member;
//use Project\Domains\Company\Authentication\Domain\Member\MemberRepositoryInterface;
use Project\Infrastructure\Hashers\Contracts\PasswordHasherInterface;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
//        private MemberRepositoryInterface $repository,
//        private CompanyRepositoryInterface $companyRepository,
        private PasswordHasherInterface $passwordHasher
    )
    {

    }

    public function __invoke(Command $command): void
    {
//        $company = $this->companyRepository->findByUuid($command->companyUuid);
//
//        $member = Member::fromPrimitives(
//            $command->uuid,
//            $command->email,
//            $this->passwordHasher->hash('12345Secret_')
//        );
//
//        $company->addMember($member);
//
//        // dump(__METHOD__, $member);
//        $this->repository->save($member);
    }
}
