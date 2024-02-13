<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Company\Domain\University;

use Project\Shared\Domain\Collection;

/**
 * @property-read University[] $items
 */
final class Universities extends Collection
{
    #[\Override]
    protected function type(): string
    {
        return University::class;
    }

    #[\Override]
    protected function translatorClass(): string
    {
        return UniversityTranslate::class;
    }
}
