<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Country\Infrastructure\Country\Repositories\Doctrine\Filter\Pipelines;

use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\QueryBuilder;
use Project\Domains\Admin\Country\Infrastructure\Country\Filters\QueryFilter;
use Project\Domains\Admin\University\Domain\Department\Department;
use Project\Domains\Admin\University\Domain\University\University;
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
        $queryBuilder->innerJoin(University::class, 'cu_u', Join::WITH, 'cu_u.countryUuid = c.uuid')
            ->andWhere('cu_u.uuid IN (:universityUuids)')
            ->setParameter('universityUuids', $queryFilter->universityUuids)
        ;
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
