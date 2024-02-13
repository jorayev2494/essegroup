<?php

declare(strict_types=1);

namespace Project\Shared\Application\Command\DTOs;

readonly class CommandTranslate
{
    public function __construct(
        public string $locale,
        public CommandTranslateValue $commandTranslateValue
    )
    {

    }
}
