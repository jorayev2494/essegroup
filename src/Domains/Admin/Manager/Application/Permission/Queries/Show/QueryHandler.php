<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Application\Permission\Queries\Show;

use Project\Domains\Admin\Manager\Application\Permission\Queries\Show\Output\Output;
use Project\Domains\Admin\Manager\Domain\Permission\Exceptions\PermissionNotFoundDomainException;
use Project\Domains\Admin\Manager\Domain\Permission\PermissionRepositoryInterface;
use Project\Domains\Admin\Manager\Domain\Permission\ValueObjects\Id;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private PermissionRepositoryInterface $repository
    ) { }

    public function __invoke(Query $query): Output
    {
        $permission = $this->repository->findById(Id::fromValue($query->id));

        $permission ?? throw new PermissionNotFoundDomainException();

        return Output::make($permission);
    }
}