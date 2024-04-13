<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Language\Infrastructure\Language\Repositories\Doctrine\Filter\Pipelines;

use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\QueryBuilder;
use Project\Domains\Admin\Language\Infrastructure\Language\Filters\QueryFilter;
use Project\Domains\Admin\University\Domain\Department\Department;
use Project\Shared\Infrastructure\Repository\Doctrine\Filter\Contracts\BaseFilterPipe;

class FilterByAlias extends BaseFilterPipe
{
    /**
     * @param QueryBuilder $queryBuilder
     * @param QueryFilter $queryFilter
     * @return void
     */
    public function execute(QueryBuilder $queryBuilder, object $queryFilter): void
    {
        $queryBuilder->innerJoin(Department::class, 'ld_a', Join::WITH, 'ld_a.languageUuid = l.uuid')
            ->andWhere('ld_a.aliasUuid IN (:aliasUuids)')
            ->setParameter('aliasUuids', $queryFilter->aliasUuids);
    }

    /**
     * @param QueryFilter $queryFilter
     * @return bool
     */
    public function canExecute(object $queryFilter): bool
    {
        return count($queryFilter->aliasUuids) > 0;
    }
}
