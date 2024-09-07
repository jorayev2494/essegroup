<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Notification\Infrastructure\Notification\Repositories\Doctrine\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Project\Domains\Admin\Notification\Domain\Notification\ValueObjects\Uuid;

class UuidType extends Type
{
    public const NAME = 'admin_notification_notification_uuid';

    #[\Override]
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getGuidTypeDeclarationSQL($column);
    }

    /**
     * @param Uuid $value
     * @param AbstractPlatform $platform
     * @return mixed
     * @throws \Doctrine\DBAL\Types\ConversionException
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        return $value?->value;
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
