<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Application\Role\Commands\UpdatePermissions;

use Project\Domains\Admin\Manager\Domain\Role\Exceptions\RoleNotFoundDomainException;
use Project\Domains\Admin\Manager\Domain\Role\RoleRepositoryInterface;
use Project\Domains\Admin\Manager\Domain\Role\Services\Contracts\RolePermissionServiceInterface;
use Project\Domains\Admin\Manager\Domain\Role\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private RoleRepositoryInterface $repository,
        private RolePermissionServiceInterface $rolePermissionService
    ) { }

    public function __invoke(Command $command): void
    {
        $role = $this->repository->findByUuid(Uuid::fromValue($command->uuid));

        $role ?? throw new RoleNotFoundDomainException();

        $this->rolePermissionService->updatePermissions($role, $command->permissionIds);

        $this->repository->save($role);
    }
}