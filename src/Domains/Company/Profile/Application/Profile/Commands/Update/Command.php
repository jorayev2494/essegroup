<?php

declare(strict_types=1);

namespace Project\Domains\Company\Profile\Application\Profile\Commands\Update;

use Project\Shared\Domain\Bus\Command\CommandInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

readonly class Command implements CommandInterface
{
    public function __construct(
        public string $firstName,
        public string $lastName,
        public string $email,
        public ?UploadedFile $avatar
    ) { }
}