<?php

namespace Project\Domains\Admin\Country\Domain\Country;

use Project\Shared\Contracts\ArrayableInterface;
use Project\Shared\Domain\Collection;

class CountryCollection extends Collection
{

    #[\Override]
    protected function type(): string
    {
        return Country::class;
    }

    #[\Override]
    protected function translatorClass(): string
    {
        return CountryTranslate::class;
    }

    public function translateItems(string $locale = null): self
    {
        $translateClassName = $this->translatorClass();

        foreach ($this->getIterator() as $item) {
            $translateClassName::execute($item, $locale);
        }

        return $this;
    }

    public function toArray(): array
    {
        return array_map(
            static fn (ArrayableInterface $item): array => $item->toArray(),
            iterator_to_array($this->getIterator())
        );
    }
}
