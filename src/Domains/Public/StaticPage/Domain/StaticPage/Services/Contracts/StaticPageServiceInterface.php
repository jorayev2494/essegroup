<?php

declare(strict_types=1);

namespace Project\Domains\Public\StaticPage\Domain\StaticPage\Services\Contracts;

interface StaticPageServiceInterface
{
    public function show(string $uuid): array;
}
