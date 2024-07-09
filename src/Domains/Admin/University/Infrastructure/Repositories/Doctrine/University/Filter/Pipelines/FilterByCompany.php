<?php

namespace Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\University\Filter\Pipelines;

use Doctrine\ORM\QueryBuilder;
use Project\Domains\Admin\University\Infrastructure\University\Filters\QueryFilter;
use Project\Shared\Infrastructure\Repository\Doctrine\Filter\Contracts\BaseFilterPipe;

class FilterByCompany extends BaseFilterPipe
{
    /**
     * @param QueryBuilder $queryBuilder
     * @param QueryFilter $queryFilter
     * @return void
     */
    public function execute(QueryBuilder $queryBuilder, object $queryFilter): void
    {
        $queryBuilder->andWhere('u.companyUuid = :companyUuid')
            ->setParameter('companyUuid', $queryFilter->companyUuid)
        ;
    }

    /**
     * @param QueryFilter $queryFilter
     * @return bool
     */
    public function canExecute(object $queryFilter): bool
    {
        return $queryFilter->companyUuid !== null;
    }
}
