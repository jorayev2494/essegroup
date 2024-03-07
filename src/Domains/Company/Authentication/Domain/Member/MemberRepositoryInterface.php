<?php

declare(strict_types=1);

namespace Project\Domains\Company\Authentication\Domain\Member;

use Project\Domains\Company\Authentication\Domain\Member\ValueObjects\Email;

interface MemberRepositoryInterface
{
    public function findByEmail(Email $email): ?Member;

    public function save(Member $member): void;
}
