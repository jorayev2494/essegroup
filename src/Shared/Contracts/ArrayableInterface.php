<?php

namespace Project\Shared\Contracts;

interface ArrayableInterface
{
    /**
     * Get the instance as an array.
     *
     * @return array<TKey, TValue>
     */
    public function toArray(): array;
}
