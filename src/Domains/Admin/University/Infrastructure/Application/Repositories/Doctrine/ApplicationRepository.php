<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Infrastructure\Application\Repositories\Doctrine;

use Doctrine\ORM\Query\Expr\Join;
use Project\Domains\Admin\Student\Domain\Student\Student;
use Project\Domains\Admin\University\Application\Application\Queries\Index\Query as IndexQuery;
use Project\Domains\Admin\University\Application\Application\Queries\ByStudentUuid\Query as ByStudentUuidQuery;
use Project\Domains\Admin\University\Domain\Application\Application;
use Project\Domains\Admin\University\Domain\Application\ApplicationCollection;
use Project\Domains\Admin\University\Domain\Application\ApplicationRepositoryInterface;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\Status;
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
        $query = $this->entityRepository->createQueryBuilder('a')
            ->innerJoin(Student::class, 'aSs', Join::WITH, 'aSs.uuid = a.studentUuid');

        if ($httpQuery->search->searchBy === 'full_name' && $httpQuery->search->search !== null) {
            [$firstName] = explode(' ', $httpQuery->search->search);

            $query->andWhere("aSs.fullName.firstName LIKE :first_name")
                ->setParameter('first_name', '%' . $firstName . '%');

            $query->orWhere("aSs.fullName.lastName LIKE :last_name")
                ->setParameter('last_name', '%' . $firstName . '%');

            if (str_contains(' ', $httpQuery->search->search)) {
                [, $lastName] = explode(' ', $httpQuery->search->search);

                $query->andWhere("aSs.fullName.lastName LIKE :last_name")
                    ->setParameter('last_name', '%' . $lastName . '%');
            }
        }

        if (count($httpQuery->filter->companyUuids) > 0) {
            $query// ->innerJoin(Student::class, 'aSs', Join::WITH, 'aSs.uuid = a.studentUuid')
                ->andWhere('aSs.companyUuid IN (:companyUuids)')
                ->setParameter('companyUuids', $httpQuery->filter->companyUuids);
        }

        if (count($httpQuery->filter->universityUuids) > 0) {
            $query->andWhere('a.universityUuid IN (:universityUuids)')
                ->setParameter('universityUuids', $httpQuery->filter->universityUuids);
        }

        if (count($httpQuery->filter->studentUuids) > 0) {
            $query->andWhere('a.studentUuid IN (:studentUuids)')
                ->setParameter('studentUuids', $httpQuery->filter->studentUuids);
        }

        if (count($httpQuery->filter->statusValueUuids) > 0) {
            $currentStatusUuids = [];

            $this->getApplicationCountWhereCurrentStatusAre($httpQuery->filter->statusValueUuids)
                ->forEach(static function (Application $app) use(&$currentStatusUuids): void {
                    $currentStatusUuids[] = $app->getUuid()->value;
                });

            $query->andWhere('a.uuid IN (:applicationUuids)')
                ->setParameter('applicationUuids', $currentStatusUuids);
        }

        return $this->paginator($query->getQuery(), $httpQuery->paginator);
    }

    public function getApplicationCountWhereCurrentStatusAre(array $statusUuids, array $companyUuids = []): ApplicationCollection
    {
        $query = $this->entityRepository->createQueryBuilder('a')
            ->innerJoin(Status::class, 's', Join::WITH, 's.applicationUuid = a.uuid')
            ->andWhere('s.statusValueUuid IN (:statusValueUuids)')
            ->setParameter('statusValueUuids', $statusUuids);

        if (count($companyUuids) > 0) {
            $query->innerJoin(Student::class, 'std', Join::WITH, 'std.uuid = a.studentUuid')
                ->andWhere('std.companyUuid IN (:companyUuid)')
                ->setParameter('companyUuid', $companyUuids);
        }

        return (new ApplicationCollection($query->getQuery()->getResult()))
            ->filter(static fn (Application $app): bool => in_array($app->getStatus()->getStatusValue()->getUuid()->value, $statusUuids));
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
