<?php

declare(strict_types=1);

namespace Project\Infrastructure\Cache;

use Project\Infrastructure\Cache\Contracts\CacheManagerInterface;
use \DateTimeImmutable;
use \Closure;

readonly class CacheManager implements CacheManagerInterface
{
    public function __construct(
        private \Illuminate\Cache\CacheManager $manager
    ) { }

    public function remember(string $key, DateTimeImmutable $ttl, Closure $callback): mixed
    {
        return $this->manager->remember($key, $ttl, $callback);
    }

    public function forgot(string $key): bool
    {
        return $this->manager->forget($key);
    }
}
