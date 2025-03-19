<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\EmailApplication\Commands\EmailApplication;

use Project\Shared\Domain\Bus\Command\CommandInterface;

readonly class Command implements CommandInterface
{
    public function __construct(
        public string $uuid,
        public string $firstName,
        public string $lastName,
        public string $fatherFirstName,
        public string $motherFirstName,
        public string $phone,
        public string $additionalPhone,
        public ?string $note
    ) { }
}