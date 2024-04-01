<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\Application\Commands\Update;

use Project\Shared\Application\Command\DTOs\CommandTranslateValue;
use Project\Shared\Domain\Bus\Command\CommandInterface;

class Command implements CommandInterface
{
    /**
     * @var array<string, CommandTranslateValue> $statusNotes
     */
    public array $statusNotes;

    public function __construct(
        public readonly string $uuid,
        public readonly string $fullName,
        public readonly string $birthday,
        public readonly string $passportNumber,
        public readonly string $email,
        public readonly string $phone,
        public readonly string $universityUuid,
        public readonly array $departmentUuids,
        public readonly string $countryUuid,
        public readonly string $status,
        array $statusNotes,
        public string $companyUuid,
        public readonly ?string $fatherName,
        public readonly ?string $motherName,
        public readonly ?string $friendPhone,
        public readonly ?string $homeAddress,
    )
    {
        $this->setNoteTranslations($statusNotes);
    }

    private function setNoteTranslations(array $statusNotes): void
    {
        $this->statusNotes = [];

        foreach ($statusNotes as $locale => $translates) {
            foreach ($translates as $field => $value) {
                $this->statusNotes[$locale][] = new CommandTranslateValue($field, $value);
            }
        }
    }
}
