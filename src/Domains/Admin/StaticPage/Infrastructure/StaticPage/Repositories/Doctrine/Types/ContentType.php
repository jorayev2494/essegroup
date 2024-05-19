<?php

declare(strict_types=1);

namespace Project\Domains\Admin\StaticPage\Infrastructure\StaticPage\Repositories\Doctrine\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Project\Domains\Admin\StaticPage\Domain\StaticPage\ValueObjects\Content;

class ContentType extends Type
{
    public const NAME = 'admin_domain_static_page_content';

    #[\Override]
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    /**
     * @param Content $value
     * @param AbstractPlatform $platform
     * @return string|null
     * @throws \Doctrine\DBAL\Types\ConversionException
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        return $value->value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): Content
    {
        return Content::fromValue($value);
    }

    #[\Override]
    public function getName(): string
    {
        return self::NAME;
    }
}
