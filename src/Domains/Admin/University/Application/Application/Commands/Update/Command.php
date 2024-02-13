<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\Application\Commands\Update;

use Project\Shared\Domain\Bus\Command\CommandInterface;

readonly class Command implements CommandInterface
{
    public function __construct(
        public string $uuid,
        public string $email,
        public string $phone,
        public string $status,
        public ?string $note,
    )
    {

    }
}
