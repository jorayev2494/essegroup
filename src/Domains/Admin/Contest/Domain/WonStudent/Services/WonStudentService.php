<?php

namespace Project\Domains\Admin\Contest\Domain\WonStudent\Services;

use DateTimeImmutable;
use Project\Domains\Admin\Contest\Domain\WonStudent\Services\Contracts\WonStudentServiceInterface;
use Project\Domains\Admin\Contest\Domain\WonStudent\WonStudent;

class WonStudentService implements WonStudentServiceInterface
{
    public function changeGiftGivenAt(WonStudent $wonStudent, ?string $giftGivenAt): void
    {
        if ($giftGivenAt === null) {
            $wonStudent->changeGiftGivenAt(null);
        } else {
            $wonStudent->changeGiftGivenAt(new DateTimeImmutable($giftGivenAt));
        }
    }
}
