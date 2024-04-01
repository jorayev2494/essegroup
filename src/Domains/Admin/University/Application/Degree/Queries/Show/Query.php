<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\Degree\Queries\Show;

use Project\Shared\Domain\Bus\Query\BaseHttpQueryParams;
use Project\Shared\Domain\Bus\Query\QueryInterface;
use Project\Shared\Infrastructure\Repository\Doctrine\PaginatorHttpQueryParams;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

readonly class Query implements QueryInterface
{
    public function __construct(
        public string $uuid
    )
    {

    }
}
