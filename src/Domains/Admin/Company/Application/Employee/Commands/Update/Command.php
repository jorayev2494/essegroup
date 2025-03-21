<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Company\Application\Employee\Commands\Update;

use Project\Shared\Domain\Bus\Command\CommandInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

readonly class Command implements CommandInterface
{
    public function __construct(
       public string $uuid,
       public string $companyUuid,
       public string $firstName,
       public string $lastName,
       public string $email,
       public ?UploadedFile $avatar
    ) {}
}
