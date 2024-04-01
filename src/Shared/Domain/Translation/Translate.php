<?php

namespace Project\Shared\Domain\Translation;

use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Types\TypeRegistry;
use Project\Shared\Contracts\NullableInterface;
use Project\Shared\Domain\Contracts\EntityId;
use Project\Shared\Domain\Contracts\EntityUuid;

abstract class Translate
{
    private const DEFAULT_LOCALE = 'en';

    protected const COLUMNS_WITH_TRANSLATE = [];

    private static function getLocale(?string $locale = null): string
    {
        return $locale ?? \request()->headers->get('accept-language') ?? self::DEFAULT_LOCALE;
    }

    protected static function translate(?TranslatableInterface $item, ?string $locale = null): ?TranslatableInterface
    {
        if (self::itemIsNotNull($item)) {
            foreach (static::COLUMNS_WITH_TRANSLATE as $column => $columnType) {
                /** @var AbstractTranslation $trans */
                $trans = $item->getTranslations()->findFirst(
                    static fn (int $idx, AbstractTranslation $el): bool =>
                        $el->getField() === $column && $el->getLocale() === self::getLocale($locale)
                );

                $content = $trans?->getContent();
                $value = array_key_exists($columnType, Type::getTypesMap()) ? $content : $columnType::fromValue($content);

                $setMethodName = 'set' . ucwords($column);
                $item->$setMethodName($value);
            }

            return $item;
        }

        return null;
    }

    private static function itemIsNotNull(TranslatableInterface $item): bool
    {
        return ($item instanceof EntityUuid && $item->getUuid()->isNotNull()) || ($item instanceof EntityId && $item->getId()->isNotNull());
    }
}
