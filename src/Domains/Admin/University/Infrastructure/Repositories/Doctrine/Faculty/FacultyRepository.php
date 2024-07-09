<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\Faculty;

use Doctrine\ORM\Query\Expr\Join;
use Project\Domains\Admin\University\Application\Faculty\Queries\Index\Query;
use Project\Domains\Admin\University\Domain\Department\Department;
use Project\Domains\Admin\University\Domain\Faculty\Faculty;
use Project\Domains\Admin\University\Domain\Faculty\FacultyCollection;
use Project\Domains\Admin\University\Domain\Faculty\FacultyRepositoryInterface;
use Project\Domains\Admin\University\Domain\Faculty\ValueObjects\Uuid;
use Project\Domains\Admin\University\Domain\University\University;
use Project\Domains\Admin\University\Infrastructure\Faculty\Filters\QueryFilter;
use Project\Shared\Infrastructure\Repository\Contracts\BaseAdminEntityRepository;
use Project\Shared\Infrastructure\Repository\Doctrine\Paginator;

class FacultyRepository extends BaseAdminEntityRepository implements FacultyRepositoryInterface
{

    #[\Override]
    protected function getEntity(): string
    {
        return Faculty::class;
    }

    #[\Override]
    public function findByUuid(Uuid $uuid): ?Faculty
    {
        return $this->entityRepository->find($uuid);
    }

    #[\Override]
    public function paginate(Query $httpQuery): Paginator
    {
        $query = $this->entityRepository->createQueryBuilder('f')->getQuery();

        return $this->paginator($query, $httpQuery->paginator);
    }

    #[\Override]
    public function list(QueryFilter $queryFilter): FacultyCollection
    {
        $query = $this->entityRepository->createQueryBuilder('f');

        if (count($queryFilter->countryUuids) > 0) {
            $query->innerJoin(Department::class, 'fd_c', Join::WITH, 'fd_c.facultyUuid = f.uuid')
                ->innerJoin(University::class, 'fdu_c', Join::WITH, 'fdu_c.uuid = fd_c.universityUuid')
                ->andWhere('fdu_c.countryUuid IN (:countryUuids)')
                ->setParameter('countryUuids', $queryFilter->countryUuids);
        }

        if (count($queryFilter->languageUuids) > 0) {
            $query->innerJoin(Department::class, 'fd_l', Join::WITH, 'fd_l.facultyUuid = f.uuid')
                ->andWhere('fd_l.languageUuid IN (:languageUuids)')
                ->setParameter('languageUuids', $queryFilter->languageUuids);
        }

        if (count($queryFilter->degreeUuids) > 0) {
            $query->innerJoin(Department::class, 'fd_d', Join::WITH, 'fd_d.facultyUuid = f.uuid')
                ->andWhere('fd_d.degreeUuid IN (:degreeUuids)')
                ->setParameter('degreeUuids', $queryFilter->degreeUuids);
        }

        if (count($queryFilter->universityUuids) > 0) {
            $query->andWhere('f.universityUuid IN (:universityUuids)')
                ->setParameter('universityUuids', $queryFilter->universityUuids);
        }

        if (count($queryFilter->aliasUuids) > 0) {
            $query->innerJoin('f.departments', 'fd', 'fd.facultyUuid = f.uuid')
                ->andWhere('fd.aliasUuid IN (:aliasUuid)')
                ->setParameter('aliasUuid', $queryFilter->aliasUuids);
        }

        return new FacultyCollection($query->getQuery()->getResult());
    }

    #[\Override]
    public function save(Faculty $university): void
    {
        $this->entityRepository->getEntityManager()->persist($university);
        $this->entityRepository->getEntityManager()->flush();
    }

    #[\Override]
    public function delete(Faculty $university): void
    {
        $this->entityRepository->getEntityManager()->remove($university);
        $this->entityRepository->getEntityManager()->flush();
    }
}
