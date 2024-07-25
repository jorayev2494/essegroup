<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Application\Permission\Queries\Index;

use Project\Domains\Admin\Manager\Application\Permission\Queries\Index\Output\Output;
use Project\Domains\Admin\Manager\Domain\Permission\PermissionRepositoryInterface;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private PermissionRepositoryInterface $repository
    ) { }

    public function __invoke(Query $query): Output
    {
        return Output::make($this->repository->paginate($query));
    }
}