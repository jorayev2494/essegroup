<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Country\Infrastructure\Country\Repositories\Doctrine\Filter;

use Project\Domains\Admin\Country\Infrastructure\Country\Repositories\Doctrine\Filter\Pipelines\FilterByAlias;
use Project\Domains\Admin\Country\Infrastructure\Country\Repositories\Doctrine\Filter\Pipelines\FilterByFaculty;
use Project\Domains\Admin\Country\Infrastructure\Country\Repositories\Doctrine\Filter\Pipelines\FilterByLanguage;
use Project\Domains\Admin\Country\Infrastructure\Country\Repositories\Doctrine\Filter\Pipelines\FilterByUniversity;
use Project\Shared\Infrastructure\Repository\Doctrine\Filter\BaseFilterQueryBuilder;
use Project\Shared\Infrastructure\Repository\Doctrine\Filter\FilterPipelineSendDTO;

class FilterQueryBuilder extends BaseFilterQueryBuilder
{
    public static function build(FilterPipelineSendDTO $sendData): void
    {
        self::instancePipeline($sendData)
            ->pipe([
                FilterByAlias::class,
                FilterByLanguage::class,
                FilterByUniversity::class,
                FilterByFaculty::class,
            ])
            ->thenReturn();
    }
}
