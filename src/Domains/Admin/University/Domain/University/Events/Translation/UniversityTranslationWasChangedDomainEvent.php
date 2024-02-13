<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\University\Events\Translation;

use Project\Shared\Domain\Translation\DomainEvents\TranslationWasChangedDomainEvent;

readonly class UniversityTranslationWasChangedDomainEvent extends TranslationWasChangedDomainEvent
{

    #[\Override]
    public static function eventName(): string
    {
        return 'university_university_translation.was.changed';
    }
}
