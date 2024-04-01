<?php

namespace Project\Shared\Contracts;

interface ComparableInterface
{
    public function isEqual(): bool;

    public function isNotEqual(): bool;
}
