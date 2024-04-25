<?php

declare(strict_types=1);

namespace Project\Domains\Company\University\Application\Application\Queries\ByStudentUuid;

use Project\Shared\Domain\Bus\Query\QueryInterface;
use Project\Shared\Infrastructure\Repository\Doctrine\PaginatorHttpQueryParams;

readonly class Query implements QueryInterface
{
    public function __construct(
        public string $studentUuid,
        public PaginatorHttpQueryParams $paginator
    ) { }

    public function toArray(): array
    {
        return [

        ];
    }
}
