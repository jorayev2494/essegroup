<?php

declare(strict_types=1);

namespace Project\Shared\Infrastructure\Repository\Doctrine\Filter;

use Illuminate\Pipeline\Pipeline;

abstract class BaseFilterQueryBuilder
{
    protected static function instancePipeline(FilterPipelineSendDTO $sendData): Pipeline
    {
        return app()->make(Pipeline::class)->send($sendData);
    }

    abstract public static function build(FilterPipelineSendDTO $sendData): void;
}
