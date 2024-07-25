<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Application\Role\Queries\List;

use Project\Domains\Admin\Manager\Application\Role\Queries\List\Output\Output;
use Project\Domains\Admin\Manager\Domain\Role\RoleRepositoryInterface;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private RoleRepositoryInterface $roleRepository
    ) { }

    public function __invoke(Query $query): Output
    {
        return Output::make($this->roleRepository->list($query));
    }
}