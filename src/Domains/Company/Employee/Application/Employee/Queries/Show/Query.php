<?php

declare(strict_types=1);

namespace Project\Domains\Company\Employee\Application\Employee\Queries\Show;

use Project\Shared\Domain\Bus\Query\QueryInterface;

readonly class Query implements QueryInterface
{
    public function __construct(
        public string $uuid
    ) { }
}