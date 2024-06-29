<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\Department;

use Doctrine\ORM\Query\Expr\Join;
use Project\Domains\Admin\University\Application\Department\Queries\Index\Query;
use Project\Domains\Admin\University\Domain\Department\Department;
use Project\Domains\Admin\University\Domain\Department\DepartmentCollection;
use Project\Domains\Admin\University\Domain\Department\DepartmentRepositoryInterface;
use Project\Domains\Admin\University\Domain\Department\Name\DepartmentName;
use Project\Domains\Admin\University\Domain\Department\Name\DepartmentNameTranslation;
use Project\Domains\Admin\University\Domain\Department\ValueObjects\Uuid;
use Project\Domains\Admin\University\Domain\Faculty\Faculty;
use Project\Domains\Admin\University\Domain\University\University;
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

        if (count($queryFilter->countryUuids) > 0) {
            $query->innerJoin(University::class, 'du_c', Join::WITH, 'du_c.uuid = d.universityUuid')
                ->andWhere('du_c.countryUuid IN (:countryUuids)')
                ->setParameter('countryUuids', $queryFilter->countryUuids);
        }

        if (count($queryFilter->aliasUuids) > 0) {
            $query->andWhere('d.aliasUuid IN (:aliasUuids)')
                ->setParameter('aliasUuids', $queryFilter->aliasUuids);
        }

        if (count($queryFilter->languageUuids) > 0) {
            $query->andWhere('d.languageUuid IN (:languageUuids)')
                ->setParameter('languageUuids', $queryFilter->languageUuids);
        }

        if (count($queryFilter->degreeUuids) > 0) {
            $query->andWhere('d.degreeUuid IN (:degreeUuids)')
                ->setParameter('degreeUuids', $queryFilter->degreeUuids);
        }

        if (count($queryFilter->universityUuids) > 0) {
            $query->andWhere('d.universityUuid IN (:universityUuids)')
                ->setParameter('universityUuids', $queryFilter->universityUuids);
        }

        if (count($queryFilter->facultyUuids) > 0) {
            $query->andWhere('d.facultyUuid IN (:facultyUuids)')
                ->setParameter('facultyUuids', $queryFilter->facultyUuids);
        }

        return new DepartmentCollection($query->getQuery()->getResult());
    }

    public function paginate(Query $httpQuery): Paginator
    {
        $query = $this->entityRepository->createQueryBuilder('d');

        if ($httpQuery->search->searchBy === 'name' && $httpQuery->search->search !== null) {
            $query->innerJoin(DepartmentName::class, 'dn', Join::WITH, 'dn.uuid = d.nameUuid')
                ->innerJoin(DepartmentNameTranslation::class, 'dn_dnt', Join::WITH, 'dn_dnt.departmentNameUuid = dn.uuid')
                ->andWhere('dn_dnt.content LIKE :name')
                ->setParameter('name', '%' . $httpQuery->search->search . '%');
        }

        if (count($httpQuery->filter->countryUuids) > 0) {
            $query->innerJoin(University::class, 'du_c', Join::WITH, 'du_c.uuid = d.universityUuid')
                ->andWhere('du_c.countryUuid IN (:countryUuids)')
                ->setParameter('countryUuids', $httpQuery->filter->countryUuids);
        }

        if (count($httpQuery->filter->aliasUuids) > 0) {
            $query->andWhere('d.aliasUuid IN (:aliasUuids)')
                ->setParameter('aliasUuids', $httpQuery->filter->aliasUuids);
        }

        if (count($httpQuery->filter->languageUuids) > 0) {
            $query->andWhere('d.languageUuid IN (:languageUuids)')
                ->setParameter('languageUuids', $httpQuery->filter->languageUuids);
        }

        if (count($httpQuery->filter->degreeUuids) > 0) {
            $query->andWhere('d.degreeUuid IN (:degreeUuids)')
                ->setParameter('degreeUuids', $httpQuery->filter->degreeUuids);
        }

        if (count($httpQuery->filter->universityUuids) > 0) {
            $query->andWhere('d.universityUuid IN (:universityUuids)')
                ->setParameter('universityUuids', $httpQuery->filter->universityUuids);
        }

        if (count($httpQuery->filter->departmentNameUuids) > 0) {
            $query->andWhere('d.nameUuid IN (:departmentNameUuids)')
                ->setParameter('departmentNameUuids', $httpQuery->filter->departmentNameUuids);
        }

        if (count($httpQuery->filter->facultyUuids) > 0) {
            $query->andWhere('d.facultyUuid IN (:facultyUuids)')
                ->setParameter('facultyUuids', $httpQuery->filter->facultyUuids);
        }

        if (count($httpQuery->filter->facultyNameUuids) > 0) {
            $query->innerJoin(Faculty::class, 'f', Join::WITH, 'f.uuid = d.facultyUuid')
                ->andWhere('f.nameUuid IN (:facultyNameUuids)')
                ->setParameter('facultyNameUuids', $httpQuery->filter->facultyNameUuids);
        }

        if (count($httpQuery->filter->uuids) > 0) {
            $query->andWhere('d.uuid IN (:uuids)')
                ->setParameter('uuids', $httpQuery->filter->uuids);
        }

        return $this->paginator($query->getQuery(), $httpQuery->paginator);
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
