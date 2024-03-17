<?php

declare(strict_types=1);

namespace Project\Domains\Company\Company\Domain\Company\Services\Contracts;

use Project\Domains\Company\Company\Application\Company\Commands\Update\Command;

interface CompanyServiceInterface
{
    public function show(string $uuid): array;

    public function update(Command $command): void;
}
