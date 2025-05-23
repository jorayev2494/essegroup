<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Announcement\Infrastructure\Announcement\Repositories\Doctrine\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Project\Domains\Admin\Announcement\Domain\Announcement\ValueObjects\ForItemEnum;

class ForType extends Type
{

    public const NAME = 'company_domain_announcement_announcement_for';

    #[\Override]
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    /**
     * @param ForItemEnum $value
     * @param AbstractPlatform $platform
     * @return mixed
     * @throws \Doctrine\DBAL\Types\ConversionException
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        return $value->value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ForItemEnum
    {
        return ForItemEnum::from($value);
    }

    #[\Override]
    public function getName(): string
    {
        return self::NAME;
    }
}
