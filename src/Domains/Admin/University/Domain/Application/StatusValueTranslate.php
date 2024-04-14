<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\Application;

use Project\Domains\Admin\University\Domain\Application\ValueObjects\StatusValueDescription;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\StatusValueValue;
use Project\Shared\Domain\Translation\Translate;

class StatusValueTranslate extends Translate
{
    protected const COLUMNS_WITH_TRANSLATE = [
        'value' => StatusValueValue::class,
        'description' => StatusValueDescription::class,
    ];

    public static function execute(?StatusValue $item, ?string $locale = null): ?StatusValue
    {
        return parent::translate($item, $locale);
    }
}
