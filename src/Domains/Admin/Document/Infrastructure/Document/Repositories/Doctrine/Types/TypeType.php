<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Document\Infrastructure\Document\Repositories\Doctrine\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Project\Domains\Admin\Document\Domain\Document\ValueObjects\TypeEnum;

class TypeType extends Type
{
    public const NAME = 'admin_domain_document_document_type';

    #[\Override]
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    /**
     * @param TypeEnum $value
     * @param AbstractPlatform $platform
     * @return mixed
     * @throws \Doctrine\DBAL\Types\ConversionException
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        return $value->value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): TypeEnum
    {
        return TypeEnum::from($value);
    }

    #[\Override]
    public function getName(): string
    {
        return self::NAME;
    }
}
