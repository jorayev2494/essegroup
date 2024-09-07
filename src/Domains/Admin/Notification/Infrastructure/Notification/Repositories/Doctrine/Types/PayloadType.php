<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Notification\Infrastructure\Notification\Repositories\Doctrine\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Project\Domains\Admin\Notification\Domain\Notification\ValueObjects\Payload;

class PayloadType extends Type
{
    public const NAME = 'admin_notification_notification_payload';

    #[\Override]
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getJsonTypeDeclarationSQL($column);
    }

    /**
     * @param Payload $value
     * @param AbstractPlatform $platform
     * @return mixed
     * @throws \Doctrine\DBAL\Types\ConversionException
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        return json_encode($value->value);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): Payload
    {
        return Payload::fromValue(json_decode($value, true));
    }

    #[\Override]
    public function getName(): string
    {
        return self::NAME;
    }
}
