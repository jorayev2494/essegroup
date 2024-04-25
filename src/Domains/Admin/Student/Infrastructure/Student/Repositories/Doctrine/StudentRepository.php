<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Student\Infrastructure\Student\Repositories\Doctrine;

use Project\Domains\Admin\Student\Application\Queries\Index\Query;
use Project\Domains\Admin\Student\Domain\Student\Student;
use Project\Domains\Admin\Student\Domain\Student\StudentRepositoryInterface;
use Project\Domains\Admin\Student\Domain\Student\ValueObjects\Uuid;
use Project\Shared\Infrastructure\Repository\Contracts\BaseAdminEntityRepository;
use Project\Shared\Infrastructure\Repository\Doctrine\Paginator;

class StudentRepository extends BaseAdminEntityRepository implements StudentRepositoryInterface
{
    protected function getEntity(): string
    {
        return Student::class;
    }

    public function paginate(Query $httpQuery): ?Paginator
    {
        $query = $this->entityRepository->createQueryBuilder('s');

        if (count($companyUuids = $httpQuery->filter->companyUuids) > 0) {
            $query->andWhere('s.companyUuid IN (:companyUuids)')
                ->setParameter('companyUuids', $companyUuids);
        }

        $query->orderBy('s.createdAt', 'DESC');

        return $this->paginator($query, $httpQuery->paginator);
    }

    public function findByUuid(Uuid $uuid): ?Student
    {
        return $this->entityRepository->find($uuid);
    }

    public function save(Student $student): void
    {
        $this->entityRepository->getEntityManager()->persist($student);
        $this->entityRepository->getEntityManager()->flush();
    }

    public function delete(Student $student): void
    {
        $this->entityRepository->getEntityManager()->remove($student);
        $this->entityRepository->getEntityManager()->flush();
    }
}
