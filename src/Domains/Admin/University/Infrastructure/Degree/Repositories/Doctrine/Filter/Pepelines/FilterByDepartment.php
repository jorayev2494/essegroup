<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Infrastructure\Degree\Repositories\Doctrine\Filter\Pepelines;

use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\QueryBuilder;
use Project\Domains\Admin\University\Domain\Department\Department;
use Project\Domains\Admin\University\Infrastructure\Degree\Filters\QueryFilter;
use Project\Shared\Infrastructure\Repository\Doctrine\Filter\Contracts\BaseFilterPipe;

class FilterByDepartment extends BaseFilterPipe
{
    /**
     * @param QueryBuilder $queryBuilder
     * @param QueryFilter $queryFilter
     * @return void
     */
    public function execute(QueryBuilder $queryBuilder, object $queryFilter): void
    {
        $queryBuilder->innerJoin(Department::class, 'dd_d', Join::WITH, 'dd_d.degreeUuid = d.uuid')
            ->andWhere('dd_d.uuid IN (:departmentUuids)')
            ->setParameter('departmentUuids', $queryFilter->departmentUuids);
    }

    /**
     * @param QueryFilter $queryFilter
     * @return bool
     */
    public function canExecute(object $queryFilter): bool
    {
        return count($queryFilter->departmentUuids) > 0;
    }
}
