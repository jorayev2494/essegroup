<?php

namespace Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\Department\Name;

use Project\Domains\Admin\University\Application\DepartmentName\Queries\Index\Query;
use Project\Domains\Admin\University\Domain\Department\Name\DepartmentName;
use Project\Domains\Admin\University\Domain\Department\Name\DepartmentNameCollection;
use Project\Domains\Admin\University\Domain\Department\Name\DepartmentNameRepositoryInterface;
use Project\Domains\Admin\University\Domain\Department\Name\ValueObjects\Uuid;
use Project\Shared\Infrastructure\Repository\Contracts\BaseAdminEntityRepository;
use Project\Shared\Infrastructure\Repository\Doctrine\Paginator;

class DepartmentNameRepository extends BaseAdminEntityRepository implements DepartmentNameRepositoryInterface
{
    protected function getEntity(): string
    {
        return DepartmentName::class;
    }

    public function paginate(Query $httpQuery): Paginator
    {
        $query = $this->entityRepository->createQueryBuilder('dn');

        return $this->paginator($query, $httpQuery->paginator);
    }

    public function list(): DepartmentNameCollection
    {
        return new DepartmentNameCollection(
            $this->entityRepository->createQueryBuilder('dn')
                ->getQuery()
                ->getResult()
        );
    }

    public function findByUuid(Uuid $uuid): ?DepartmentName
    {
        return $this->entityRepository->find($uuid);
    }

    public function save(DepartmentName $departmentName): void
    {
        $this->entityRepository->getEntityManager()->persist($departmentName);
        $this->entityRepository->getEntityManager()->flush();
    }

    public function delete(DepartmentName $departmentName): void
    {
        $this->entityRepository->getEntityManager()->remove($departmentName);
        $this->entityRepository->getEntityManager()->flush();
    }
}
