<?php

declare(strict_types=1);

namespace Project\Domains\Company\Profile\Application\Profile\Commands\ChangePassword;

use Project\Shared\Domain\Bus\Command\CommandInterface;

readonly class Command implements CommandInterface
{
    public function __construct(
        public string $deviceId,
        public string $currentPassword,
        public string $newPassword
    ) { }
}
