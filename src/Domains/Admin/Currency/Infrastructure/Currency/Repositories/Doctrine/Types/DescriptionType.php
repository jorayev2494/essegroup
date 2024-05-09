<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Currency\Infrastructure\Currency\Repositories\Doctrine\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Project\Domains\Admin\Currency\Domain\Currency\ValueObjects\Description;

class DescriptionType extends Type
{
    public const NAME = 'admin_domain_currency_currency_description';

    #[\Override]
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    /**
     * @param Description $value
     * @param AbstractPlatform $platform
     * @return mixed
     * @throws \Doctrine\DBAL\Types\ConversionException
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        return $value->value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): Description
    {
        return Description::fromValue($value);
    }

    #[\Override]
    public function getName(): string
    {
        return self::NAME;
    }
}
