<?php

namespace Project\Infrastructure\Cache\Contracts;

use \Closure;
use \DateTimeImmutable;

interface CacheManagerInterface
{
    public function remember(string $key, DateTimeImmutable $ttl, Closure $callback): mixed;

    public function forgot(string $key): bool;
}
