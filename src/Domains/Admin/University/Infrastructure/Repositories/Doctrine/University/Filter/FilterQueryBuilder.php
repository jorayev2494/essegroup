<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\University\Filter;

use Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\University\Filter\Pipelines\FilterByAlias;
use Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\University\Filter\Pipelines\FilterByCity;
use Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\University\Filter\Pipelines\FilterByCompany;
use Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\University\Filter\Pipelines\FilterByCountry;
use Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\University\Filter\Pipelines\FilterByDegree;
use Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\University\Filter\Pipelines\FilterByDepartment;
use Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\University\Filter\Pipelines\FilterByDepartmentName;
use Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\University\Filter\Pipelines\FilterByFaculty;
use Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\University\Filter\Pipelines\FilterByLanguage;
use Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\University\Filter\Pipelines\FilterTopPosition;
use Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\University\Filter\Pipelines\OnlyTheCountryList;
use Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\University\Filter\Pipelines\FilterIsForForeign;
use Project\Shared\Infrastructure\Repository\Doctrine\Filter\BaseFilterQueryBuilder;
use Project\Shared\Infrastructure\Repository\Doctrine\Filter\FilterPipelineSendDTO;

class FilterQueryBuilder extends BaseFilterQueryBuilder
{
    public static function build(FilterPipelineSendDTO $sendData): void
    {
        self::instancePipeline($sendData)
            ->pipe([
                FilterByFaculty::class,
                FilterByCountry::class,
                FilterByCity::class,
                // FilterByCompany::class,
                FilterByDepartment::class,
                FilterByDepartmentName::class,
                FilterByDegree::class,
                OnlyTheCountryList::class,
                FilterByLanguage::class,
                FilterByAlias::class,
                FilterTopPosition::class,
                FilterIsForForeign::class,
            ])
            ->thenReturn();
    }
}
