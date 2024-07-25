<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Infrastructure\Role\Repositories\Doctrine\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Project\Domains\Admin\Manager\Domain\Role\ValueObjects\Name;

class NameType extends Type
{
    public const NAME = 'admin_manager_role_name';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    /**
     * @param Name $value
     * @param AbstractPlatform $platform
     * @return ?string
     * @throws \Doctrine\DBAL\Types\ConversionException
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        return $value->value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): Name
    {
        return Name::fromValue($value);
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
