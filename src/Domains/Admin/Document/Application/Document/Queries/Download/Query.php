<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Document\Application\Document\Queries\Download;

use Project\Shared\Domain\Bus\Query\QueryInterface;

readonly class Query implements QueryInterface
{
    public function __construct(
        public string $uuid
    ) { }
}
