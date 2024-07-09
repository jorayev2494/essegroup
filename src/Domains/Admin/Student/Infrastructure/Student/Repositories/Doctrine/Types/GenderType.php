<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Student\Infrastructure\Student\Repositories\Doctrine\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Project\Domains\Admin\Student\Domain\Student\ValueObjects\Enums\Gender;

class GenderType extends Type
{

    public const NAME = 'admin_domain_student_student_gender';

    #[\Override]
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    /**
     * @param Gender $value
     * @param AbstractPlatform $platform
     * @return mixed
     * @throws \Doctrine\DBAL\Types\ConversionException
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        return $value?->value;
    }

    /**
     * @param string $value
     * @param AbstractPlatform $platform
     * @return Gender|null
     * @throws \Doctrine\DBAL\Types\ConversionException
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): ?Gender
    {
        return $value !== null ? Gender::from($value) : null;
    }

    #[\Override]
    public function getName(): string
    {
        return self::NAME;
    }
}
