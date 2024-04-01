<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\Alias\Commands\Delete;

use Project\Shared\Application\Command\Traits\TranslationsTrait;
use Project\Shared\Domain\Bus\Command\CommandInterface;

readonly class Command implements CommandInterface
{
    public function __construct(
        public string $uuid
    ) {

    }
}
