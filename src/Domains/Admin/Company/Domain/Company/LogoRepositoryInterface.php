<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Company\Domain\Company;

use Project\Domains\Admin\Company\Domain\Company\ValueObjects\Logo;

interface LogoRepositoryInterface
{
    public function findByUuid(string $uuid): ?Logo;

    public function delete(Logo $logo): void;
}
