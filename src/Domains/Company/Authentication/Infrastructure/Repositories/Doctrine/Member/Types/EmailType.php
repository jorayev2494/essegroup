<?php

declare(strict_types=1);

namespace Project\Domains\Company\Authentication\Infrastructure\Repositories\Doctrine\Member\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Project\Domains\Company\Authentication\Domain\Member\ValueObjects\Email;

class EmailType extends Type
{
    public const NAME = 'company_auth_member_email';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    /**
     * @param Email $value
     * @param AbstractPlatform $platform
     * @return string
     * @throws \Doctrine\DBAL\Types\ConversionException
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        return $value->value;
    }

    /**
     * @param string $value
     * @param AbstractPlatform $platform
     * @return Email
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): Email
    {
        return Email::fromValue($value);
    }

    public function getName(): string
    {
        return self::NAME;
    }
}