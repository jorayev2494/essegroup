<?php

namespace Project\Shared\Domain;

use Doctrine\Common\Collections\ArrayCollection;
use InvalidArgumentException;
use Project\Shared\Contracts\ArrayableInterface;
use IteratorAggregate;
use Countable;

abstract class Collection extends ArrayCollection implements Countable, IteratorAggregate, ArrayableInterface
{
    public function __construct(array $elements = [])
    {
        $this->arrayOf($elements, $this->type());
        parent::__construct($elements);
    }

    private function arrayOf(array $elements, string $class): void
    {
        foreach ($elements as $element) {
            $this->instanceOf($element, $class);
        }
    }

    private function instanceOf($element, string $class): void
    {
        if (!$element instanceof $class) {
            throw new InvalidArgumentException(
                sprintf('The object <%s> is not an instance of <%s>', $class, get_class($element))
            );
        }
    }

    abstract protected function type(): string;

    abstract protected function translatorClass(): string;

    public function forEach(\Closure $p): void
    {
        foreach ($this->getIterator() as $key => $element) {
            $p($element, $key);
        }
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
