<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Infrastructure\Repositories\Doctrine\Member;

use Doctrine\Common\Collections\ArrayCollection;
use Project\Domains\Admin\Authentication\Domain\Member\Member;
use Project\Domains\Admin\Authentication\Domain\Member\MemberRepositoryInterface;
use Project\Domains\Admin\Authentication\Domain\Member\ValueObjects\Email;
use Project\Shared\Infrastructure\Repository\Contracts\BaseAdminEntityRepository;

class MemberRepository extends BaseAdminEntityRepository implements MemberRepositoryInterface
{
    public function getEntity(): string
    {
        return Member::class;
    }

    public function findByEmail(Email $email): ?Member
    {
        return $this->entityRepository->findOneBy(['email' => $email]);
    }

    public function save(Member $member): void
    {
        $this->entityRepository->getEntityManager()->persist($member);
        $this->entityRepository->getEntityManager()->flush();
    }
}
