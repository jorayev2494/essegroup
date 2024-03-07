<?php

declare(strict_types=1);

namespace Project\Domains\Public\University\Application\Faculty\Queries\Show;

use Project\Domains\Admin\University\Infrastructure\Faculty\Filters\HttpQueryFilterDTO;
use Project\Shared\Domain\Bus\Query\BaseHttpQueryParams;
use Project\Shared\Domain\Bus\Query\QueryInterface;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

readonly class Query implements QueryInterface
{
    public function __construct(
        public string $uuid
    )
    {

    }
}
