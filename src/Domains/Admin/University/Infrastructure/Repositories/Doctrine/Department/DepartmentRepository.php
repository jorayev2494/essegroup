<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\Department;

use Project\Domains\Admin\University\Domain\Department\Department;
use Project\Domains\Admin\University\Domain\Department\DepartmentRepositoryInterface;
use Project\Domains\Admin\University\Domain\Department\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Query\BaseHttpQueryParams;
use Project\Shared\Infrastructure\Repository\Contracts\BaseAdminEntityRepository;
use Project\Shared\Infrastructure\Repository\Doctrine\Paginator;

class DepartmentRepository extends BaseAdminEntityRepository implements DepartmentRepositoryInterface
{
    #[\Override]
    protected function getEntity(): string
    {
        return Department::class;
    }

    public function findByUuid(Uuid $uuid): ?Department
    {
        return $this->entityRepository->find($uuid);
    }

    public function paginate(BaseHttpQueryParams $httpQueryParams): Paginator
    {
        $query = $this->entityRepository->createQueryBuilder('d')->getQuery();

        return $this->paginator($query, $httpQueryParams->paginatorHttpQueryParams);
    }

    public function save(Department $department): void
    {
        $this->entityRepository->getEntityManager()->persist($department);
        $this->entityRepository->getEntityManager()->flush();
    }

    public function delete(Department $department): void
    {
        $this->entityRepository->getEntityManager()->remove($department);
        $this->entityRepository->getEntityManager()->flush();
    }
}
