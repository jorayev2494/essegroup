<?php

declare(strict_types=1);

namespace Project\Shared\Infrastructure\Repository\Doctrine\Search\Contracts;

use Closure;
use Project\Shared\Infrastructure\Repository\Doctrine\Search\SearchPipelineSendDTO;

abstract class BaseSearchPipe
{
    public function handle(SearchPipelineSendDTO $data, Closure $next): SearchPipelineSendDTO
    {
        if ($this->canExecute($data)) {
            $this->execute($data);
        }

        return $next($data);
    }

    abstract public function execute(SearchPipelineSendDTO $data): void;

    abstract public function canExecute(SearchPipelineSendDTO $data): bool;
}
