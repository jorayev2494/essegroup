<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Announcement\Domain\Announcement;

use Doctrine\Common\Collections\ArrayCollection;
use Project\Shared\Contracts\ArrayableInterface;

class AnnouncementCollection extends ArrayCollection
{
    public function translateItems(string $locale = null): self
    {
        $translateClassName = $this->translatorClass();

        foreach ($this->getIterator() as $item) {
            $translateClassName::execute($item, $locale);
        }

        return $this;
    }

    public function translatorClass(): string
    {
        return AnnouncementTranslate::class;
    }

    public function toArray(): array
    {
        return array_map(
            static fn (ArrayableInterface $item): array => $item->toArray(),
            iterator_to_array($this->getIterator())
        );
    }
}
