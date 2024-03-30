<?php

namespace Project\Domains\Admin\University\Infrastructure\Degree\Repositories\Doctrine\Filter;

use Project\Domains\Admin\University\Infrastructure\Degree\Repositories\Doctrine\Filter\Pepelines\FilterByCompany;
use Project\Shared\Infrastructure\Repository\Doctrine\Filter\BaseFilterQueryBuilder;
use Project\Shared\Infrastructure\Repository\Doctrine\Filter\FilterPipelineSendDTO;

class FilterQueryBuilder extends BaseFilterQueryBuilder
{
    public static function build(FilterPipelineSendDTO $sendData): void
    {
        self::instancePipeline($sendData)
            ->pipe([
                FilterByCompany::class,
            ])
            ->thenReturn();
    }
}
