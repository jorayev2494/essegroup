<?php

namespace Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\University\Filter\Pipelines;

use Doctrine\ORM\QueryBuilder;
use Project\Domains\Admin\University\Infrastructure\University\Filters\QueryFilter;
use Project\Shared\Infrastructure\Repository\Doctrine\Filter\Contracts\BaseFilterPipe;

class FilterByDegree extends BaseFilterPipe
{
    /**
     * @param QueryBuilder $queryBuilder
     * @param QueryFilter $queryFilter
     * @return void
     */
    public function execute(QueryBuilder $queryBuilder, object $queryFilter): void
    {
        $queryBuilder->innerJoin('u.faculties', 'uf')
            ->innerJoin('uf.departments', 'ufd', 'ufd.facultyUuid = uf.uuid')
            ->innerJoin('ufd.degrees', 'ufdd')
            ->andWhere('ufdd.uuid IN (:degreeUuids)')
            ->setParameter('degreeUuids', $queryFilter->degreeUuids);
    }

    /**
     * @param QueryFilter $queryFilter
     * @return bool
     */
    public function canExecute(object $queryFilter): bool
    {
        return count($queryFilter->degreeUuids) > 0;
    }
}
