<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Infrastructure\Application\Repositories\Doctrine\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\StatusValueValue;

class StatusValueValueType extends Type
{
    public const NAME = 'admin_domain_university_application_status_value_value';

    #[\Override]
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    /**
     * @param StatusValueValue $value
     * @param AbstractPlatform $platform
     * @return string
     * @throws \Doctrine\DBAL\Types\ConversionException
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        return $value->value;
    }

    /**
     * @param string $value
     * @param AbstractPlatform $platform
     * @return mixed
     * @throws \Doctrine\DBAL\Types\ConversionException
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): StatusValueValue
    {
        return StatusValueValue::fromValue($value);
    }

    #[\Override]
    public function getName(): string
    {
        return self::NAME;
    }
}
