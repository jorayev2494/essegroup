<?php

namespace Project\Shared\Domain;

use InvalidArgumentException;
use Project\Shared\Contracts\ArrayableInterface;
use Traversable;
use ArrayIterator;
use IteratorAggregate;
use Countable;

abstract class Collection implements Countable, IteratorAggregate, ArrayableInterface
{
    protected readonly array $items;

    public function __construct(array $items = [])
    {
        $this->arrayOf($items, $this->type());
        $this->items = $items;
    }

    private function arrayOf(array $items, string $class): void
    {
        foreach ($items as $item) {
            $this->instanceOf($item, $class);
        }
    }

    private function instanceOf($item, string $class): void
    {
        if (!$item instanceof $class) {
            throw new InvalidArgumentException(
                sprintf('The object <%s> is not an instance of <%s>', $class, get_class($item))
            );
        }
    }

    abstract protected function type(): string;

    abstract protected function translatorClass(): string;

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->items);
    }

    final public function count(): int
    {
        return count($this->items);
    }

    final public function items(): array
    {
        return $this->items;
    }

    public function translateItems(string $locale = 'en'): self
    {
        $translateClassName = $this->translatorClass();

        foreach ($this->items as $item) {
            $translateClassName::execute($item, $locale);
        }

        return $this;
    }

    public function toArray(): array
    {
        return array_map(static fn (ArrayableInterface $item): array => $item->toArray(), $this->items);
    }
}
