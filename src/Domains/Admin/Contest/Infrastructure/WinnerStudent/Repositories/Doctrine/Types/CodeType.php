<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Contest\Infrastructure\WinnerStudent\Repositories\Doctrine\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Project\Domains\Admin\Contest\Domain\WonStudent\ValueObjects\Code;

class CodeType extends Type
{

    public const NAME = 'admin_domain_contest_winner_student_code';

    #[\Override]
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getIntegerTypeDeclarationSQL($column);
    }

    /**
     * @param Code $value
     * @param AbstractPlatform $platform
     * @return mixed
     * @throws \Doctrine\DBAL\Types\ConversionException
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?int
    {
        return $value?->value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): Code
    {
        return Code::fromValue($value);
    }

    #[\Override]
    public function getName(): string
    {
        return self::NAME;
    }
}
