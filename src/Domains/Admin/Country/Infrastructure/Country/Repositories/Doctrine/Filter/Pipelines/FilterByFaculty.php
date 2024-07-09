<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Country\Infrastructure\Country\Repositories\Doctrine\Filter\Pipelines;

use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\QueryBuilder;
use Project\Domains\Admin\Country\Infrastructure\Country\Filters\QueryFilter;
use Project\Domains\Admin\University\Domain\Department\Department;
use Project\Domains\Admin\University\Domain\Faculty\Faculty;
use Project\Domains\Admin\University\Domain\University\University;
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
        $queryBuilder->innerJoin(University::class, 'cu_f', Join::WITH, 'cu_f.countryUuid = c.uuid')
            ->innerJoin(Faculty::class, 'cuf_f', Join::WITH, 'cuf_f.universityUuid = cu_f.uuid')
            ->andWhere('cuf_f.uuid IN (:facultyUuids)')
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
