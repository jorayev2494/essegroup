<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Contest\Application\WonStudent\Commands\Update;

use Project\Shared\Domain\Bus\Command\CommandInterface;

readonly class Command implements CommandInterface
{
    public function __construct(
        public int $code,
        public ?string $changeGiftGivenAt,
        public ?string $note
    ) { }
}
