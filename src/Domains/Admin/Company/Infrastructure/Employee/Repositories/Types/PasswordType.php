<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Company\Infrastructure\Employee\Repositories\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Project\Domains\Admin\Company\Domain\Employee\ValueObjects\Password;

class PasswordType extends Type
{

    public const NAME = 'company_domain_employee_employee_password';

    #[\Override]
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    /**
     * @param Password $value
     * @param AbstractPlatform $platform
     * @return mixed
     * @throws \Doctrine\DBAL\Types\ConversionException
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        return $value?->value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): Password
    {
        return Password::fromValue($value);
    }

    #[\Override]
    public function getName(): string
    {
        return self::NAME;
    }
}
