<?php

declare(strict_types=1);

namespace Project\Domains\Admin\StaticPage\Infrastructure\StaticPage\Repositories\Caches\Redis;

use Project\Domains\Admin\StaticPage\Domain\StaticPage\StaticPage;
use Project\Domains\Admin\StaticPage\Domain\StaticPage\StaticPageCacheRepositoryInterface;
use Project\Domains\Admin\StaticPage\Domain\StaticPage\ValueObjects\Slug;
use Project\Shared\Infrastructure\Repository\Cache\BaseCacheRepository;

readonly class StaticPageCacheRepository extends BaseCacheRepository implements StaticPageCacheRepositoryInterface
{
    public function getEntity(): string
    {
        return StaticPage::class;
    }

    public function findBySlug(Slug $slug): ?StaticPage
    {
//        return $this->cacheRepository->remember(
//            $slug->value,
//            now()->addMinutes(),
//            fn (): ?StaticPage => $this->repository->findBySlug($slug)
//        );

        return null;
    }

    public function delete(StaticPage $staticPage): void
    {
        $this->cacheRepository->forget($staticPage->getUuid()->value);
    }
}
