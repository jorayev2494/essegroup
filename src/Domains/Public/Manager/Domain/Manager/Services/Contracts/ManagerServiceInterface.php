<?php

declare(strict_types=1);

namespace Project\Domains\Public\Manager\Domain\Manager\Services\Contracts;

interface ManagerServiceInterface
{
    public function list(): array;

    public function show(string $uuid): array;
}
