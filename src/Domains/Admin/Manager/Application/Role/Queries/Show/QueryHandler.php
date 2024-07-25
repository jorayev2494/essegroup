<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Application\Role\Queries\Show;

use Project\Domains\Admin\Manager\Application\Role\Queries\Show\Output\Output;
use Project\Domains\Admin\Manager\Domain\Role\Exceptions\RoleNotFoundDomainException;
use Project\Domains\Admin\Manager\Domain\Role\RoleRepositoryInterface;
use Project\Domains\Admin\Manager\Domain\Role\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private RoleRepositoryInterface $roleRepository
    ) { }

    public function __invoke(Query $query): Output
    {
        $role = $this->roleRepository->findByUuid(Uuid::fromValue($query->uuid));

        $role ?? throw new RoleNotFoundDomainException();

        return Output::make($role);
    }
}