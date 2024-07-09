<?php

declare(strict_types=1);

namespace Project\Shared\Infrastructure\Repository\Doctrine\Filter;

use Doctrine\ORM\QueryBuilder;

readonly class FilterPipelineSendDTO
{
    public function __construct(
        public QueryBuilder $queryBuilder
    ) {

    }
}
