<?php

declare(strict_types=1);

namespace Project\Shared\Domain\File;

class UrlPattern
{
    public const IMAGE_MIME_TYPES = [
        MimeTypes::JPG->value,
        MimeTypes::JPEG->value,
        MimeTypes::PNG->value,
        MimeTypes::GIF->value,
    ];

    public readonly MimeTypes $mimeType;

    public static function make(File $file): string
    {
        return '{endpoint}' . self::makePattern($file);
    }

    private static function makePattern(File $file): string
    {
        return match (true) {
            self::isImage($file->getMimeType()) => sprintf('%s/%sx%s/%s', $file->getPath(), '{width}', '{height}', $file->getFileName()),

            default => sprintf('%s/%s', $file->getPath(), $file->getFileName())
        };
    }

    private static function isImage(string $mimeType): bool
    {
        return in_array($mimeType, self::IMAGE_MIME_TYPES);
    }
}
