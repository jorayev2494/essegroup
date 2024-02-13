<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\Company\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Project\Domains\Admin\University\Domain\Company\ValueObjects\Status;

class StatusType extends Type
{

    public const NAME = 'admin_domain_university_company_status';

    #[\Override]
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    /**
     * @param Status $value
     * @param AbstractPlatform $platform
     * @return mixed
     * @throws \Doctrine\DBAL\Types\ConversionException
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        return $value->value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): Status
    {
        return Status::fromValue($value);
    }

    #[\Override]
    public function getName(): string
    {
        return self::NAME;
    }
}
