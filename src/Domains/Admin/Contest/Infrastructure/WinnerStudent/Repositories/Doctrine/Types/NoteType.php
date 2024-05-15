<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Contest\Infrastructure\WinnerStudent\Repositories\Doctrine\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Types\Types;
use Project\Domains\Admin\Contest\Domain\WonStudent\ValueObjects\Note;

class NoteType extends Type
{

    public const NAME = 'admin_domain_contest_winner_student_note';

    #[\Override]
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getDoctrineTypeMapping(Types::TEXT);
    }

    /**
     * @param Note $value
     * @param AbstractPlatform $platform
     * @return mixed
     * @throws \Doctrine\DBAL\Types\ConversionException
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        return $value?->value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): Note
    {
        return Note::fromValue($value);
    }

    #[\Override]
    public function getName(): string
    {
        return self::NAME;
    }
}
