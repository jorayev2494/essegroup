<?php

declare(strict_types=1);

namespace Project\Domains\Company\Manager\Infrastructure\Manager\Repositories\Doctrine\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Project\Domains\Company\Manager\Domain\Manager\ValueObjects\Email;

class EmailType extends Type
{

    public const NAME = 'company_domain_manager_email';

    #[\Override]
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    /**
     * @param Email $value
     * @param AbstractPlatform $platform
     * @return mixed
     * @throws \Doctrine\DBAL\Types\ConversionException
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        return $value->value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): Email
    {
        return Email::fromValue($value);
    }

    #[\Override]
    public function getName(): string
    {
        return self::NAME;
    }
}