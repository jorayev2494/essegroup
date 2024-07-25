<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Domain\Role;

use Project\Domains\Admin\Manager\Domain\Role\ValueObjects\Name;
use Project\Shared\Domain\Translation\TranslatableInterface;
use Project\Shared\Domain\Translation\Translate;

class RoleTranslate extends Translate
{
    protected const COLUMNS_WITH_TRANSLATE = [
        'name' => Name::class,
    ];

    public static function execute(?TranslatableInterface $item, ?string $locale = null): ?Role
    {
        return parent::translate($item, $locale);
    }
}
