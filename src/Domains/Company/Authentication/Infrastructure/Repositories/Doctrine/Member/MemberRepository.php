<?php

declare(strict_types=1);

namespace Project\Domains\Company\Authentication\Infrastructure\Repositories\Doctrine\Member;

use Project\Domains\Company\Authentication\Domain\Member\Member;
use Project\Domains\Company\Authentication\Domain\Member\MemberRepositoryInterface;
use Project\Domains\Company\Authentication\Domain\Member\ValueObjects\Email;
use Project\Domains\Company\Authentication\Domain\Member\ValueObjects\Uuid;
use Project\Shared\Infrastructure\Repository\Contracts\BaseCompanyEntityRepository;

class MemberRepository extends BaseCompanyEntityRepository implements MemberRepositoryInterface
{
    public function getEntity(): string
    {
        return Member::class;
    }

    public function findByEmail(Email $email): ?Member
    {
        return $this->entityRepository->findOneBy(['email' => $email]);
    }

    public function findByUuid(Uuid $uuid): ?Member
    {
        return $this->entityRepository->find($uuid);
    }

    public function save(Member $member): void
    {
        $this->entityRepository->getEntityManager()->persist($member);
        $this->entityRepository->getEntityManager()->flush();
    }
}
