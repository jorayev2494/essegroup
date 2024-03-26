<?php

namespace Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\University\Search;

use Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\University\Search\Pipelines\SearchByName;
use Project\Shared\Infrastructure\Repository\Doctrine\Search\BaseSearchQueryBuilder;
use Project\Shared\Infrastructure\Repository\Doctrine\Search\SearchPipelineSendDTO;

class SearchQueryBuilder extends BaseSearchQueryBuilder
{
    public static function build(SearchPipelineSendDTO $sendData): void
    {
        self::instancePipeline($sendData)
            ->pipe([
                SearchByName::class,
            ])
            ->thenReturn();
    }
}
