<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Infrastructure\Application\Repositories\Doctrine;

use Project\Domains\Admin\University\Application\Application\Queries\Index\Query as IndexQuery;
use Project\Domains\Admin\University\Application\Application\Queries\ByStudentUuid\Query as ByStudentUuidQuery;
use Project\Domains\Admin\University\Domain\Application\Application;
use Project\Domains\Admin\University\Domain\Application\ApplicationCollection;
use Project\Domains\Admin\University\Domain\Application\ApplicationRepositoryInterface;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\Uuid;
use Project\Shared\Infrastructure\Repository\Contracts\BaseAdminEntityRepository;
use Project\Shared\Infrastructure\Repository\Doctrine\Paginator;

class ApplicationRepository extends BaseAdminEntityRepository implements ApplicationRepositoryInterface
{
    #[\Override]
    protected function getEntity(): string
    {
        return Application::class;
    }

    public function paginate(IndexQuery $httpQuery): Paginator
    {
        $query = $this->entityRepository->createQueryBuilder('a');

        return $this->paginator($query->getQuery(), $httpQuery->paginator);
    }

    public function paginateByStudentUuid(ByStudentUuidQuery $httpQuery): Paginator
    {
        $query = $this->entityRepository->createQueryBuilder('a');

        $query->where('a.studentUuid = :studentUuid')
            ->setParameter('studentUuid', $httpQuery->studentUuid);

        return $this->paginator($query->getQuery(), $httpQuery->paginator);
    }

    public function findByUuid(Uuid $uuid): ?Application
    {
        return $this->entityRepository->find($uuid);
    }

    public function findManyByCompanyUuid(string $companyUuid): ApplicationCollection
    {
        return new ApplicationCollection(
            $this->entityRepository->createQueryBuilder('a')
                ->where('a.companyUuid = :companyUuid')
                ->setParameter('companyUuid', $companyUuid)
                ->getQuery()
                ->getResult()
        );
    }

    public function findManyByUniversityUuid(string $universityUuid): ApplicationCollection
    {
        return new ApplicationCollection(
            $this->entityRepository->createQueryBuilder('a')
                ->where('a.universityUuid = :universityUuid')
                ->setParameter('universityUuid', $universityUuid)
                ->getQuery()
                ->getResult()
        );
    }

    public function findManyByDepartmentUuid(string $departmentUuid): ApplicationCollection
    {
        return new ApplicationCollection(
            $this->entityRepository->createQueryBuilder('a')
                ->where('a.departmentUuid = :departmentUuid')
                ->setParameter('departmentUuid', $departmentUuid)
                ->getQuery()
                ->getResult()
        );
    }

    public function findManyByCountryUuid(string $countryUuid): ApplicationCollection
    {
        return new ApplicationCollection(
            $this->entityRepository->createQueryBuilder('a')
                ->where('a.countryUuid = :countryUuid')
                ->setParameter('countryUuid', $countryUuid)
                ->getQuery()
                ->getResult()
        );
    }

    public function save(Application $application): void
    {
        $this->entityRepository->getEntityManager()->persist($application);
        $this->entityRepository->getEntityManager()->flush();
    }

    public function delete(Application $application): void
    {
        $this->entityRepository->getEntityManager()->remove($application);
        $this->entityRepository->getEntityManager()->flush();
    }
}
