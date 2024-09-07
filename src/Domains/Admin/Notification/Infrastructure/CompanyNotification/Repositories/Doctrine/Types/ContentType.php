<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Notification\Infrastructure\CompanyNotification\Repositories\Doctrine\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Project\Domains\Admin\Notification\Domain\CompanyNotification\ValueObjects\Title;

class ContentType extends Type
{
    public const NAME = 'admin_notification_company_notification_content';

    #[\Override]
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    /**
     * @param Title $value
     * @param AbstractPlatform $platform
     * @return mixed
     * @throws \Doctrine\DBAL\Types\ConversionException
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        return $value?->value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): Title
    {
        return Title::fromValue($value);
    }

    #[\Override]
    public function getName(): string
    {
        return self::NAME;
    }
}
