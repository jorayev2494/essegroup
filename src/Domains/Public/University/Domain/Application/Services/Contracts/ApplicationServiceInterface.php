<?php

declare(strict_types=1);

namespace Project\Domains\Public\University\Domain\Application\Services\Contracts;

use Project\Domains\Public\University\Application\Application\Commands\Create\Command;

interface ApplicationServiceInterface
{
    public function create(Command $command): void;
}
