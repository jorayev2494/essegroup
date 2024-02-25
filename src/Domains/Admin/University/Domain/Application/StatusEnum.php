<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\Application;

enum StatusEnum : string
{
    public const MANAGEMENT_NOTE_REQUIRED = [
        self::VIEWED,
    ];

    case NEW = 'new';
    case PENDING = 'pending';
    case VIEWED = 'viewed';

    public static function managementNoteRequired(self $status): bool
    {
        return in_array(
            $status,
            // array_map(
            //     static fn (StatusEnum $status): string => $status->value,
            //     StatusEnum::MANAGEMENT_NOTE_REQUIRED
            // )
            StatusEnum::MANAGEMENT_NOTE_REQUIRED
        );
    }
}
