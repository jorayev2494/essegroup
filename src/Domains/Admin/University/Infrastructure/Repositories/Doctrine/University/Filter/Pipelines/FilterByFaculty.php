<?php

namespace Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\University\Filter\Pipelines;

use Doctrine\ORM\QueryBuilder;
use Project\Domains\Admin\University\Infrastructure\University\Filters\QueryFilter;
use Project\Shared\Infrastructure\Repository\Doctrine\Filter\Contracts\BaseFilterPipe;

class FilterByFaculty extends BaseFilterPipe
{
    /**
     * @param QueryBuilder $queryBuilder
     * @param QueryFilter $queryFilter
     * @return void
     */
    public function execute(QueryBuilder $queryBuilder, object $queryFilter): void
    {
        $queryBuilder->innerJoin('u.faculties', 'uf', 'uf.universityUuid = u.uuid')
            ->innerJoin('uf.name', 'ufn')
            ->andWhere('ufn.uuid IN (:facultyUuids)')
            ->setParameter('facultyUuids', $queryFilter->facultyUuids)
        ;
    }

    /**
     * @param QueryFilter $queryFilter
     * @return bool
     */
    public function canExecute(object $queryFilter): bool
    {
        return count($queryFilter->facultyUuids) > 0;
    }
}
