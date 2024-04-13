<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Infrastructure\Alias\Repositories\Doctrine\Filter;

use Project\Domains\Admin\University\Infrastructure\Alias\Repositories\Doctrine\Filter\Pipelines\FilterByCountry;
use Project\Domains\Admin\University\Infrastructure\Alias\Repositories\Doctrine\Filter\Pipelines\FilterByDegree;
use Project\Domains\Admin\University\Infrastructure\Alias\Repositories\Doctrine\Filter\Pipelines\FilterByDepartment;
use Project\Domains\Admin\University\Infrastructure\Alias\Repositories\Doctrine\Filter\Pipelines\FilterByFaculty;
use Project\Domains\Admin\University\Infrastructure\Alias\Repositories\Doctrine\Filter\Pipelines\FilterByLanguage;
use Project\Domains\Admin\University\Infrastructure\Alias\Repositories\Doctrine\Filter\Pipelines\FilterByUniversity;
use Project\Shared\Infrastructure\Repository\Doctrine\Filter\BaseFilterQueryBuilder;
use Project\Shared\Infrastructure\Repository\Doctrine\Filter\FilterPipelineSendDTO;

class FilterQueryBuilder extends BaseFilterQueryBuilder
{
    public static function build(FilterPipelineSendDTO $sendData): void
    {
        self::instancePipeline($sendData)
            ->pipe([
                FilterByCountry::class,
                FilterByDegree::class,
                FilterByLanguage::class,
                FilterByUniversity::class,
                FilterByFaculty::class,
                FilterByDepartment::class,
            ])
            ->thenReturn();
    }
}
