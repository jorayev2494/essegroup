<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Company\Application\Company\Commands\Update;

use Project\Shared\Domain\Bus\Command\CommandInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

readonly class Command implements CommandInterface
{
    public function __construct(
        public string $uuid,
        public ?UploadedFile $logo,
        public string $name,
        public string $email,
        public string $domain,
    )
    {

    }
}
