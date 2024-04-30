<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Infrastructure\Manager\Repositories\Doctrine\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Project\Domains\Admin\Manager\Domain\Manager\ValueObjects\FirstName;

class FirstNameType extends Type
{

    public const NAME = 'company_domain_manager_manager_first_name';

    #[\Override]
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    /**
     * @param FirstName $value
     * @param AbstractPlatform $platform
     * @return mixed
     * @throws \Doctrine\DBAL\Types\ConversionException
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        return $value?->value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): FirstName
    {
        return FirstName::fromValue($value);
    }

    #[\Override]
    public function getName(): string
    {
        return self::NAME;
    }
}
