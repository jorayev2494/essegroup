<?php

declare(strict_types=1);

namespace Project\Domains\Admin\StaticPage\Domain\StaticPage;

use Project\Domains\Admin\StaticPage\Domain\StaticPage\ValueObjects\Slug;

interface StaticPageCacheRepositoryInterface
{
    public function findBySlug(Slug $slug): ?StaticPage;

    public function delete(StaticPage $staticPage): void;
}
