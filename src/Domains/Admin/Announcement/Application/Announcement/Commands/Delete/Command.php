<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Announcement\Application\Announcement\Commands\Delete;

use Project\Shared\Domain\Bus\Command\CommandInterface;

class Command implements CommandInterface
{
    public function __construct(
        public string $uuid
    ) { }
}
