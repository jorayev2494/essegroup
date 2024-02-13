<?php

declare(strict_types=1);

namespace Project\Shared\Domain\Translation\DomainEvents;

enum TranslationDomainEventTypeEnum : string
{
    case ADDED = 'added';

    case CHANGED = 'changed';

    case DELETED = 'deleted';
}
