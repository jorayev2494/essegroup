<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Infrastructure\Degree\Repositories\Doctrine\Filter\Pepelines;

use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\QueryBuilder;
use Project\Domains\Admin\University\Domain\Department\Department;
use Project\Domains\Admin\University\Domain\University\University;
use Project\Domains\Admin\University\Infrastructure\Degree\Filters\QueryFilter;
use Project\Shared\Infrastructure\Repository\Doctrine\Filter\Contracts\BaseFilterPipe;

class FilterByCountry extends BaseFilterPipe
{
    /**
     * @param QueryBuilder $queryBuilder
     * @param QueryFilter $queryFilter
     * @return void
     */
    public function execute(QueryBuilder $queryBuilder, object $queryFilter): void
    {
        $queryBuilder->innerJoin(Department::class, 'dd_c', Join::WITH, 'dd_c.degreeUuid = d.uuid')
            ->innerJoin(University::class, 'du_c', Join::WITH, 'du_c.uuid = dd_c.universityUuid')
            ->andWhere('du_c.countryUuid IN (:countryUuids)')
            ->setParameter('countryUuids', $queryFilter->countryUuids);
    }

    /**
     * @param QueryFilter $queryFilter
     * @return bool
     */
    public function canExecute(object $queryFilter): bool
    {
        return count($queryFilter->countryUuids) > 0;
    }
}
