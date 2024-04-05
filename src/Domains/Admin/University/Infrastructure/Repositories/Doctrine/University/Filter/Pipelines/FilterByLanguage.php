<?php

namespace Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\University\Filter\Pipelines;

use Doctrine\ORM\QueryBuilder;
use Project\Domains\Admin\University\Infrastructure\University\Filters\QueryFilter;
use Project\Shared\Infrastructure\Repository\Doctrine\Filter\Contracts\BaseFilterPipe;

class FilterByLanguage extends BaseFilterPipe
{
    /**
     * @param QueryBuilder $queryBuilder
     * @param QueryFilter $queryFilter
     * @return void
     */
    public function execute(QueryBuilder $queryBuilder, object $queryFilter): void
    {
        $queryBuilder->innerJoin('u.faculties', 'ufl')
            ->innerJoin('ufl.departments', 'ufld', 'ufld.facultyUuid = ufl.uuid')
            ->innerJoin('ufld.language', 'ufldd')
            ->andWhere('ufldd.uuid IN (:languageUuids)')
            ->setParameter('languageUuids', $queryFilter->languageUuids);
    }

    /**
     * @param QueryFilter $queryFilter
     * @return bool
     */
    public function canExecute(object $queryFilter): bool
    {
        return count($queryFilter->languageUuids) > 0;
    }
}
