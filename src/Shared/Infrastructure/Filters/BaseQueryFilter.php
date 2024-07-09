<?php

declare(strict_types=1);

namespace Project\Shared\Infrastructure\Filters;

use Project\Shared\Contracts\ArrayableInterface;
use Symfony\Component\HttpFoundation\Request;

abstract readonly class BaseQueryFilter implements ArrayableInterface
{
    abstract public static function makeFromRequest(Request $request): static;

    abstract public static function makeFromArray(array $data): static;
}
