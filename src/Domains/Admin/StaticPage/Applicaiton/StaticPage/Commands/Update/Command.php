<?php

declare(strict_types=1);

namespace Project\Domains\Admin\StaticPage\Applicaiton\StaticPage\Commands\Update;

use Project\Shared\Application\Command\Traits\TranslationsTrait;
use Project\Shared\Domain\Bus\Command\CommandInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Command implements CommandInterface
{
    use TranslationsTrait;

    public function __construct(
        public readonly string $slug,
        public array $translations,
        public readonly ?UploadedFile $cover
    )
    {
        $this->setTranslations($this->translations);
    }
}
