<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\Application\Commands\Update;

use Project\Shared\Domain\Bus\Command\CommandInterface;

readonly class Command implements CommandInterface
{
    public function __construct(
        public string $uuid,
        public string $fullName,
        public string $birthday,
        public string $passportNumber,
        public string $email,
        public string $phone,
        public string $universityUuid,
        public string $facultyUuid,
        public string $countryUuid,
        public string $status,
        public ?string $note,
        public ?string $fatherName,
        public ?string $motherName,
        public ?string $friendPhone,
        public ?string $homeAddress,
    )
    {

    }
}
