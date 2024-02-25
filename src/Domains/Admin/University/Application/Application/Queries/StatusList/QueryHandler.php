<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\Application\Queries\StatusList;

use Project\Domains\Admin\University\Domain\Application\StatusEnum;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __invoke(Query $query): array
    {
        return StatusEnum::cases();
    }
}
