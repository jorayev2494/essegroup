<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Language\Infrastructure\Language\Repositories\Doctrine\Filter;

use Project\Domains\Admin\Language\Infrastructure\Language\Repositories\Doctrine\Filter\Pipelines\FilterByAlias;
use Project\Domains\Admin\Language\Infrastructure\Language\Repositories\Doctrine\Filter\Pipelines\FilterByCountry;
use Project\Domains\Admin\Language\Infrastructure\Language\Repositories\Doctrine\Filter\Pipelines\FilterByDepartment;
use Project\Domains\Admin\Language\Infrastructure\Language\Repositories\Doctrine\Filter\Pipelines\FilterByFaculty;
use Project\Domains\Admin\Language\Infrastructure\Language\Repositories\Doctrine\Filter\Pipelines\FilterByUniversity;
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
