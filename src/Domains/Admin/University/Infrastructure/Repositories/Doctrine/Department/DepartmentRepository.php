<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\Department;

use Project\Domains\Admin\University\Domain\Department\Department;
use Project\Domains\Admin\University\Domain\Department\DepartmentCollection;
use Project\Domains\Admin\University\Domain\Department\DepartmentRepositoryInterface;
use Project\Domains\Admin\University\Domain\Department\ValueObjects\Uuid;
use Project\Domains\Admin\University\Infrastructure\Department\Filters\HttpQueryFilterDTO;
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

    public function findManyByUuids(array $uuids): DepartmentCollection
    {
        $query = $this->entityRepository->createQueryBuilder('d');

        $query->where('d.uuid IN (:uuids)')
            ->setParameter('uuids', $uuids);

        return new DepartmentCollection($query->getQuery()->getResult());
    }

    public function list(HttpQueryFilterDTO $httpQueryFilter): DepartmentCollection
    {
        $query = $this->entityRepository->createQueryBuilder('d');

        if ($httpQueryFilter->universityUuid !== null) {
            $query->where('d.universityUuid = :universityUuid')
                ->setParameter('universityUuid', $httpQueryFilter->universityUuid);
        }

        if ($httpQueryFilter->facultyUuid !== null) {
            $query->where('d.facultyUuid = :facultyUuid')
                ->setParameter('facultyUuid', $httpQueryFilter->facultyUuid);
        }

        return new DepartmentCollection($query->getQuery()->getResult());
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
