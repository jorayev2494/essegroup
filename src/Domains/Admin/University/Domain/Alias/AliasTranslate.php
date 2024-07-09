<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\Alias;

use Project\Domains\Admin\University\Domain\Alias\ValueObjects\Value;
use Project\Shared\Domain\Translation\Translate;

class AliasTranslate extends Translate
{
    protected const COLUMNS_WITH_TRANSLATE = [
        'value' => Value::class,
    ];

    public static function execute(?Alias $item, ?string $locale = null): ?Alias
    {
        return parent::translate($item, $locale);
    }
}
