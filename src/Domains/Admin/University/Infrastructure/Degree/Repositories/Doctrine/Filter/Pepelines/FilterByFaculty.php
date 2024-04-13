<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Infrastructure\Degree\Repositories\Doctrine\Filter\Pepelines;

use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\QueryBuilder;
use Project\Domains\Admin\University\Domain\Department\Department;
use Project\Domains\Admin\University\Infrastructure\Degree\Filters\QueryFilter;
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
        $queryBuilder->innerJoin(Department::class, 'dd_f', Join::WITH, 'dd_f.degreeUuid = d.uuid')
            ->andWhere('dd_f.facultyUuid IN (:facultyUuids)')
            ->setParameter('facultyUuids', $queryFilter->facultyUuids);
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
