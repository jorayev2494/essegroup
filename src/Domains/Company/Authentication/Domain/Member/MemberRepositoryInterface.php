<?php

declare(strict_types=1);

namespace Project\Domains\Company\Authentication\Domain\Member;

use Project\Domains\Company\Authentication\Domain\Member\ValueObjects\Email;
use Project\Domains\Company\Authentication\Domain\Member\ValueObjects\Uuid;

interface MemberRepositoryInterface
{
    public function findByEmail(Email $email): ?Member;

    public function findByUuid(Uuid $uuid): ?Member;

    public function save(Member $member): void;
}
