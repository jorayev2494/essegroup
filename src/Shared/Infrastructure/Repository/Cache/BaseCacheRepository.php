<?php

declare(strict_types=1);

namespace Project\Shared\Infrastructure\Repository\Cache;

use Project\Infrastructure\Cache\Contracts\CacheManagerInterface;

abstract readonly class BaseCacheRepository
{

    protected CacheManagerInterface $cacheRepository;

    protected string $entityKey;

    protected function __construct() {
        $this->cacheRepository = new \Project\Infrastructure\Cache\CacheManager(
            resolve(CacheManagerInterface::class)->getStore()
        );

        $this->initRepository();
    }

    private function initRepository(): void
    {
        if ($entityName = $this->getEntity()) {
            $this->entityKey = $this->makeEntityKey($entityName);
        }
    }

    abstract public function getEntity(): string;

    private function makeEntityKey(string $className): string
    {
        return strtolower(str_replace('\\', '.', $className));
    }

    public function getEntityKey(): string
    {
        return $this->entityKey;
    }
}
