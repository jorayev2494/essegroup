<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Contest\Domain\WonStudent\Services\Contracts;

use Project\Domains\Admin\Contest\Domain\WonStudent\WonStudent;

interface WonStudentServiceInterface
{
    public function changeGiftGivenAt(WonStudent $wonStudent, ?string $giftGivenAt): void;
}
