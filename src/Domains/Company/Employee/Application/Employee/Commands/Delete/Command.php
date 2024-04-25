<?php

declare(strict_types=1);

namespace Project\Domains\Company\Employee\Application\Employee\Commands\Delete;

use Project\Shared\Domain\Bus\Command\CommandInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

readonly class Command implements CommandInterface
{
    public function __construct(
        public string $uuid
    ) { }
}
