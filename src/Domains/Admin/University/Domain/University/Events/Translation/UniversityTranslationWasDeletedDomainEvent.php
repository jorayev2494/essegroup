<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\University\Events\Translation;

use Project\Shared\Domain\Translation\DomainEvents\TranslationWasDeletedDomainEvent;

readonly class UniversityTranslationWasDeletedDomainEvent extends TranslationWasDeletedDomainEvent
{

    #[\Override]
    public static function eventName(): string
    {
        return 'university_university_translation.was.deleted';
    }
}
