<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\Application;

use Doctrine\DBAL\Types\Types;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\Status;
use Project\Domains\Admin\University\Domain\University\ValueObjects\Name;
use Project\Shared\Domain\Translation\Translate;

class StatusTranslate extends Translate
{
    protected const COLUMNS_WITH_TRANSLATE = [
        'note' => Types::TEXT,
    ];

    public static function execute(?Status $item, ?string $locale = null): ?Status
    {
        return parent::translate($item, $locale);
    }
}
