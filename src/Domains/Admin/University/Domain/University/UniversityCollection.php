<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\University;

use Project\Shared\Domain\Collection;

/**
 * @property-read University[] $items
 */
final class UniversityCollection extends Collection
{
    protected function type(): string
    {
        return University::class;
    }

    protected function translatorClass(): string
    {
        return UniversityTranslate::class;
    }

    public function toArrayWithTranslations(): array
    {
        $result = [];

        foreach ($this->items as $item) {
            $result[] = array_merge(
                $item->toArray(),
                ['translations' => $item->translationsToArray()]
            );
        }

        return $result;
    }
}
