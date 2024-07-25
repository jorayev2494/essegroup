<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Infrastructure\Role\Repositories\Doctrine;

use Project\Domains\Admin\Manager\Application\Role\Queries\Index\Query as IndexQuery;
use Project\Domains\Admin\Manager\Application\Role\Queries\List\Query as ListQuery;
use Project\Domains\Admin\Manager\Domain\Role\Role;
use Project\Domains\Admin\Manager\Domain\Role\RoleCollection;
use Project\Domains\Admin\Manager\Domain\Role\RoleRepositoryInterface;
use Project\Domains\Admin\Manager\Domain\Role\ValueObjects\Uuid;
use Project\Shared\Infrastructure\Repository\Contracts\BaseAdminEntityRepository;
use Project\Shared\Infrastructure\Repository\Doctrine\Paginator;

class RoleRepository extends BaseAdminEntityRepository implements RoleRepositoryInterface
{
    protected function getEntity(): string
    {
        return Role::class;
    }

    public function findByUuid(Uuid $uuid): ?Role
    {
        return $this->entityRepository->find($uuid);
    }

    public function paginate(IndexQuery $indexQuery): Paginator
    {
        $query = $this->entityRepository->createQueryBuilder('r');

        return $this->paginator($query, $indexQuery->paginator);
    }

    public function list(ListQuery $listQuery): RoleCollection
    {
        $query = $this->entityRepository->createQueryBuilder('r');

        return new RoleCollection($query->getQuery()->getResult());
    }

    public function save(Role $role): void
    {
        $this->entityRepository->getEntityManager()->persist($role);
        $this->entityRepository->getEntityManager()->flush();
    }

    public function delete(Role $role): void
    {
        $this->entityRepository->getEntityManager()->remove($role);
        $this->entityRepository->getEntityManager()->flush();
    }
}