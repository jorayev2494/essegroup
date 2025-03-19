<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Infrastructure\EmailApplication\Repositories\Doctrine\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Project\Domains\Admin\University\Domain\EmailApplication\ValueObjects\MotherFirstName;

class MotherFirstNameType extends Type
{
    public const NAME = 'admin_domain_university_email_application_mother_first_name';

    #[\Override]
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    /**
     * @param MotherFirstName $value
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
     * @return mixed
     * @throws \Doctrine\DBAL\Types\ConversionException
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): MotherFirstName
    {
        return MotherFirstName::fromValue($value);
    }

    #[\Override]
    public function getName(): string
    {
        return self::NAME;
    }
}
