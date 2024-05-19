<?php

declare(strict_types=1);

namespace Project\Domains\Admin\StaticPage\Domain\StaticPage;

use Project\Domains\Admin\StaticPage\Domain\StaticPage\ValueObjects\Slug;
use Project\Domains\Admin\StaticPage\Domain\StaticPage\ValueObjects\Uuid;

interface StaticPageRepositoryInterface
{
    public function findByUuid(Uuid $uuid): ?StaticPage;

    public function findBySlug(Slug $slug): ?StaticPage;

    public function save(StaticPage $staticPage): void;
}
