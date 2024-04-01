<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\Department;

use Project\Domains\Admin\University\Application\Department\Queries\Index\Query;
use Project\Domains\Admin\University\Domain\Department\Department;
use Project\Domains\Admin\University\Domain\Department\DepartmentCollection;
use Project\Domains\Admin\University\Domain\Department\DepartmentRepositoryInterface;
use Project\Domains\Admin\University\Domain\Department\ValueObjects\Uuid;
use Project\Domains\Admin\University\Infrastructure\Department\Filters\QueryFilter;
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

    public function findManyByUniversityUuid(string $universityUuid): DepartmentCollection
    {
        return new DepartmentCollection(
            $this->entityRepository->createQueryBuilder('d')
                ->where('d.universityUuid = :universityUuid')
                ->setParameter('universityUuid', $universityUuid)
                ->getQuery()
                ->getResult()
        );
    }

    public function findManyByFacultyUuid(string $facultyUuid): DepartmentCollection
    {
        return new DepartmentCollection(
            $this->entityRepository->createQueryBuilder('d')
                ->where('d.facultyUuid = :facultyUuid')
                ->setParameter('facultyUuid', $facultyUuid)
                ->getQuery()
                ->getResult()
        );
    }

    public function list(QueryFilter $queryFilter): DepartmentCollection
    {
        $query = $this->entityRepository->createQueryBuilder('d');

        if ($queryFilter->universityUuid !== null) {
            $query->where('d.universityUuid = :universityUuid')
                ->setParameter('universityUuid', $queryFilter->universityUuid);
        }

        if ($queryFilter->facultyUuid !== null) {
            $query->andWhere('d.facultyUuid = :facultyUuid')
                ->setParameter('facultyUuid', $queryFilter->facultyUuid);
        }

        return new DepartmentCollection($query->getQuery()->getResult());
    }

    public function paginate(Query $httpQuery): Paginator
    {
        $query = $this->entityRepository->createQueryBuilder('d')->getQuery();

        return $this->paginator($query, $httpQuery->paginator);
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
