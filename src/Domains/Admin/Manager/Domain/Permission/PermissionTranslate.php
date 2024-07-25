<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Domain\Permission;

use Project\Domains\Admin\Manager\Domain\Permission\ValueObjects\Label;
use Project\Shared\Domain\Translation\TranslatableInterface;
use Project\Shared\Domain\Translation\Translate;

class PermissionTranslate extends Translate
{
    protected const COLUMNS_WITH_TRANSLATE = [
        'label' => Label::class,
    ];

    public static function execute(?TranslatableInterface $item, ?string $locale = null): ?Permission
    {
        return parent::translate($item, $locale);
    }
}
