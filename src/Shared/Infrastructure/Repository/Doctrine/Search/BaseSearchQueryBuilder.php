<?php

declare(strict_types=1);

namespace Project\Shared\Infrastructure\Repository\Doctrine\Search;

use Illuminate\Pipeline\Pipeline;

abstract class BaseSearchQueryBuilder
{
    public static function instancePipeline(SearchPipelineSendDTO $sendData): Pipeline
    {
        return app()->make(Pipeline::class)->send($sendData);
    }

    abstract public static function build(SearchPipelineSendDTO $sendData): void;
}
