<?php

declare(strict_types=1);

namespace Project\Shared\Infrastructure\Repository\Doctrine\Search;

use Doctrine\ORM\QueryBuilder;
use Project\Shared\Infrastructure\Filters\BaseSearch;

readonly class SearchPipelineSendDTO
{
    public function __construct(
        public QueryBuilder $queryBuilder,
        public BaseSearch $search
    ) {

    }
}
