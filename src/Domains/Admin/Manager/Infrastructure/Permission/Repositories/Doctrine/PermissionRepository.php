<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Infrastructure\Permission\Repositories\Doctrine;

use Project\Domains\Admin\Manager\Application\Permission\Queries\Index\Query as IndexQuery;
use Project\Domains\Admin\Manager\Application\Permission\Queries\List\Query as ListQuery;
use Project\Domains\Admin\Manager\Domain\Permission\Permission;
use Project\Domains\Admin\Manager\Domain\Permission\PermissionCollection;
use Project\Domains\Admin\Manager\Domain\Permission\PermissionRepositoryInterface;
use Project\Domains\Admin\Manager\Domain\Permission\ValueObjects\Id;
use Project\Shared\Infrastructure\Repository\Contracts\BaseAdminEntityRepository;
use Project\Shared\Infrastructure\Repository\Doctrine\Paginator;

class PermissionRepository extends BaseAdminEntityRepository implements PermissionRepositoryInterface
{
    protected function getEntity(): string
    {
        return Permission::class;
    }

    public function paginate(IndexQuery $indexQuery): Paginator
    {
        $query = $this->entityRepository->createQueryBuilder('p');

        return $this->paginator($query, $indexQuery->paginator);
    }

    public function list(ListQuery $listQuery): PermissionCollection
    {
        $query = $this->entityRepository->createQueryBuilder('p');
        // $query->groupBy('p.resource');

        return new PermissionCollection($query->getQuery()->getResult());
    }

    public function findById(Id $id): ?Permission
    {
        return $this->entityRepository->find($id);
    }

    public function findManyByIds(array $ids): PermissionCollection
    {
        $query = $this->entityRepository->createQueryBuilder('p')
            ->where('p.id IN (:ids)')
            ->setParameter('ids', $ids);

        return new PermissionCollection($query->getQuery()->getResult());
    }

    public function getByRoleUuids(string $roleUuid): PermissionCollection
    {
        $query = $this->entityRepository->createQueryBuilder('p')
            ->innerJoin('p.roles', 'r')
            ->where('r.uuid = :roleUuid')
            ->setParameter('roleUuid', $roleUuid);

        return new PermissionCollection($query->getQuery()->getResult());
    }

    public function save(Permission $permission): void
    {
        $this->entityRepository->getEntityManager()->persist($permission);
        $this->entityRepository->getEntityManager()->flush();
    }
}