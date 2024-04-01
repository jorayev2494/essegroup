<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Company\Infrastructure\Repositories\Doctrine\Status\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Project\Domains\Admin\Company\Domain\Status\ValueObjects\Uuid;

class UuidType extends Type
{

    public const NAME = 'admin_domain_company_status_uuid';

    #[\Override]
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    /**
     * @param Uuid $value
     * @param AbstractPlatform $platform
     * @return string
     * @throws \Doctrine\DBAL\Types\ConversionException
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        return $value->value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): Uuid
    {
        return Uuid::fromValue($value);
    }

    #[\Override]
    public function getName(): string
    {
        return self::NAME;
    }
}
