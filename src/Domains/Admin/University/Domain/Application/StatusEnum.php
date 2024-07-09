<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\Application;

enum StatusEnum : string
{
    public const MANAGEMENT_NOTE_REQUIRED = [
        self::PENDING,
        self::VIEWED,
    ];

    case NEW = 'new';
    case PENDING = 'pending';
    case VIEWED = 'viewed';

    public static function managementNoteRequired(self $status): bool
    {
        return in_array($status, StatusEnum::MANAGEMENT_NOTE_REQUIRED);
    }
}
