<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\Faculty;

use Project\Domains\Admin\University\Domain\Faculty\Faculty;
use Project\Domains\Admin\University\Domain\Faculty\FacultyCollection;
use Project\Domains\Admin\University\Domain\Faculty\FacultyRepositoryInterface;
use Project\Domains\Admin\University\Domain\Faculty\ValueObjects\Uuid;
use Project\Domains\Admin\University\Infrastructure\Faculty\Filters\HttpQueryFilterDTO;
use Project\Shared\Domain\Bus\Query\BaseHttpQueryParams;
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

    public function findManyByCompanyUuid(string $companyUuid): FacultyCollection
    {
        return new FacultyCollection(
            $this->entityRepository->createQueryBuilder('f')
                ->where('f.companyUuid = :companyUuid')
                ->setParameter('companyUuid', $companyUuid)
                ->getQuery()
                ->getResult()
        );
    }

    public function findManyByUniversityUuid(string $universityUuid): FacultyCollection
    {
        return new FacultyCollection(
            $this->entityRepository->createQueryBuilder('f')
                ->where('f.universityUuid = :universityUuid')
                ->setParameter('universityUuid', $universityUuid)
                ->getQuery()
                ->getResult()
        );
    }

    #[\Override]
    public function paginate(BaseHttpQueryParams $httpQueryParams): Paginator
    {
        $query = $this->entityRepository->createQueryBuilder('f')->getQuery();

        return $this->paginator($query, $httpQueryParams->paginatorHttpQueryParams);
    }

    #[\Override]
    public function list(HttpQueryFilterDTO $httpQueryFilter): FacultyCollection
    {
        $query = $this->entityRepository->createQueryBuilder('f');

        if ($httpQueryFilter->universityUuid !== null) {
            $query->where('f.universityUuid = :universityUuid')
                ->setParameter('universityUuid', $httpQueryFilter->universityUuid);
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
