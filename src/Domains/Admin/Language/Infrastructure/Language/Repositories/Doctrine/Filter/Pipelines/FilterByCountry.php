<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Language\Infrastructure\Language\Repositories\Doctrine\Filter\Pipelines;

use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\QueryBuilder;
use Project\Domains\Admin\Language\Infrastructure\Language\Filters\QueryFilter;
use Project\Domains\Admin\University\Domain\Department\Department;
use Project\Domains\Admin\University\Domain\University\University;
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
        $queryBuilder->innerJoin(Department::class, 'ld_c', Join::WITH, 'ld_c.languageUuid = l.uuid')
            ->innerJoin(University::class, 'ldu_c', Join::WITH, 'ldu_c.uuid = ld_c.universityUuid')
            ->andWhere('ldu_c.countryUuid IN (:countryUuids)')
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
