<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Contest\Application\WonStudent\Queries\GetByContestAndStudent;

use Project\Shared\Domain\Bus\Query\QueryInterface;

readonly class Query implements QueryInterface
{
    public function __construct(
        public string $contestUuid,
        public string $studentUuid
    ) { }
}
