<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Infrastructure\Degree\Repositories\Doctrine\Filter\Pepelines;

use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\QueryBuilder;
use Project\Domains\Admin\University\Domain\Department\Department;
use Project\Domains\Admin\University\Infrastructure\Degree\Filters\QueryFilter;
use Project\Shared\Infrastructure\Repository\Doctrine\Filter\Contracts\BaseFilterPipe;

class FilterByUniversity extends BaseFilterPipe
{
    /**
     * @param QueryBuilder $queryBuilder
     * @param QueryFilter $queryFilter
     * @return void
     */
    public function execute(QueryBuilder $queryBuilder, object $queryFilter): void
    {
        $queryBuilder->innerJoin(Department::class, 'dd_u', Join::WITH, 'dd_u.degreeUuid = d.uuid')
            ->andWhere('dd_u.universityUuid IN (:universityUuids)')
            ->setParameter('universityUuids', $queryFilter->universityUuids);
    }

    /**
     * @param QueryFilter $queryFilter
     * @return bool
     */
    public function canExecute(object $queryFilter): bool
    {
        return count($queryFilter->universityUuids) > 0;
    }
}
