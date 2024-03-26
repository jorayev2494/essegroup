<?php

declare(strict_types=1);

namespace Project\Shared\Infrastructure\Repository\Doctrine\Filter\Contracts;

use Closure;
use Doctrine\ORM\QueryBuilder;
use Project\Shared\Infrastructure\Filters\BaseQueryFilter;
use Project\Shared\Infrastructure\Repository\Doctrine\Filter\FilterPipelineSendDTO;

abstract class BaseFilterPipe
{
    public function handle(FilterPipelineSendDTO $data, Closure $next): FilterPipelineSendDTO
    {
        if ($this->canExecute($data->filter)) {
            $this->execute($data->queryBuilder, $data->filter);
        }

        return $next($data);
    }

    abstract public function execute(QueryBuilder $queryBuilder, object $queryFilter): void;

    abstract public function canExecute(object $queryFilter): bool;
}
