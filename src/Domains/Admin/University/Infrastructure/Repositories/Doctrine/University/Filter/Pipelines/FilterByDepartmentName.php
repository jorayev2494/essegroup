<?php

namespace Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\University\Filter\Pipelines;

use Doctrine\ORM\QueryBuilder;
use Project\Domains\Admin\University\Infrastructure\University\Filters\QueryFilter;
use Project\Shared\Infrastructure\Repository\Doctrine\Filter\Contracts\BaseFilterPipe;

class FilterByDepartmentName extends BaseFilterPipe
{
    /**
     * @param QueryBuilder $queryBuilder
     * @param QueryFilter $queryFilter
     * @return void
     */
    public function execute(QueryBuilder $queryBuilder, object $queryFilter): void
    {
        $queryBuilder->innerJoin('u.faculties', 'ufff', 'ufff.universityUuid = u.uuid')
            ->innerJoin('ufff.departments', 'ufffd', 'ufffd.facultyUuid = ufff.uuid')
            ->innerJoin('ufffd.name', 'ufffn')
            ->andWhere('ufffn.uuid IN (:departmentNameUuids)')
            ->setParameter('departmentNameUuids', $queryFilter->departmentNameUuids)
        ;
    }

    /**
     * @param QueryFilter $queryFilter
     * @return bool
     */
    public function canExecute(object $queryFilter): bool
    {
        return count($queryFilter->departmentNameUuids) > 0;
    }
}
