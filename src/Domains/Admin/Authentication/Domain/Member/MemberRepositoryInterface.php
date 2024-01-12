<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Domain\Member;

use Doctrine\Common\Collections\ArrayCollection;
use Project\Domains\Admin\Authentication\Domain\Member\ValueObjects\Email;

interface MemberRepositoryInterface
{
    public function findByEmail(Email $email): ?Member;

    public function save(Member $member): void;
}
