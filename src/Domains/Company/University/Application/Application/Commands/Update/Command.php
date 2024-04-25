<?php

declare(strict_types=1);

namespace Project\Domains\Company\University\Application\Application\Commands\Update;

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
        public readonly string $aliasUuid,
        public readonly string $languageUuid,
        public readonly string $degreeUuid,
        public readonly string $countryUuid,
        public readonly string $universityUuid,
        public readonly array $departmentUuids,
        public readonly string $statusValueUuid,
        array $statusNotes,
    ) {
        $this->setNoteTranslations($statusNotes);
    }

    private function setNoteTranslations(array $statusNotes): void
    {
        $this->statusNotes = [];

        foreach ($statusNotes as $locale => $translates) {
            foreach ($translates as $field => $value) {
                $this->statusNotes[$locale][] = new CommandTranslateValue($field, $value ?? '');
            }
        }
    }
}
