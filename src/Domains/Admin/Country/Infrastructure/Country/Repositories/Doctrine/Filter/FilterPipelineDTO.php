<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Country\Infrastructure\Country\Repositories\Doctrine\Filter;

use Doctrine\ORM\QueryBuilder;
use Project\Domains\Admin\Country\Infrastructure\Country\Filters\QueryFilter;
use Project\Shared\Infrastructure\Repository\Doctrine\Filter\FilterPipelineSendDTO;

readonly class FilterPipelineDTO extends FilterPipelineSendDTO
{
    public function __construct(
        QueryBuilder $queryBuilder,
        public QueryFilter $filter
    ) {
        parent::__construct($queryBuilder);
    }
}
