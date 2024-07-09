<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Infrastructure\Degree\Repositories\Doctrine\Filter;

use Project\Domains\Admin\University\Infrastructure\Degree\Repositories\Doctrine\Filter\Pepelines\FilterByAlias;
use Project\Domains\Admin\University\Infrastructure\Degree\Repositories\Doctrine\Filter\Pepelines\FilterByCountry;
use Project\Domains\Admin\University\Infrastructure\Degree\Repositories\Doctrine\Filter\Pepelines\FilterByDepartment;
use Project\Domains\Admin\University\Infrastructure\Degree\Repositories\Doctrine\Filter\Pepelines\FilterByFaculty;
use Project\Domains\Admin\University\Infrastructure\Degree\Repositories\Doctrine\Filter\Pepelines\FilterByUniversity;
use Project\Shared\Infrastructure\Repository\Doctrine\Filter\BaseFilterQueryBuilder;
use Project\Shared\Infrastructure\Repository\Doctrine\Filter\FilterPipelineSendDTO;

class FilterQueryBuilder extends BaseFilterQueryBuilder
{
    public static function build(FilterPipelineSendDTO $sendData): void
    {
        self::instancePipeline($sendData)
            ->pipe([
                FilterByAlias::class,
                FilterByCountry::class,
                FilterByUniversity::class,
                FilterByFaculty::class,
                FilterByDepartment::class,
            ])
            ->thenReturn();
    }
}
