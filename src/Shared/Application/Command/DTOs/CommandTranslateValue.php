<?php

declare(strict_types=1);

namespace Project\Shared\Application\Command\DTOs;

readonly class CommandTranslateValue
{
    public function __construct(
        public string $field,
        public string $value
    )
    {

    }
}
