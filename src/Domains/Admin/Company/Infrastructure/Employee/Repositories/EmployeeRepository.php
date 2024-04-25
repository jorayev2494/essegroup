<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Company\Infrastructure\Employee\Repositories;

use Project\Domains\Admin\Company\Application\Employee\Queries\Index\Query;
use Project\Domains\Admin\Company\Domain\Employee\Employee;
use Project\Domains\Admin\Company\Domain\Employee\EmployeeRepositoryInterface;
use Project\Domains\Admin\Company\Domain\Employee\ValueObjects\Email;
use Project\Domains\Admin\Company\Domain\Employee\ValueObjects\Uuid;
use Project\Shared\Infrastructure\Repository\Contracts\BaseAdminEntityRepository;
use Project\Shared\Infrastructure\Repository\Doctrine\Paginator;

class EmployeeRepository extends BaseAdminEntityRepository implements EmployeeRepositoryInterface
{
    protected function getEntity(): string
    {
        return Employee::class;
    }

    public function findByUuid(Uuid $uuid): ?Employee
    {
        return $this->entityRepository->find($uuid);
    }

    public function findByEmail(Email $email): ?Employee
    {
        return $this->entityRepository->findOneBy(['email' => $email]);
    }

    public function paginate(Query $httpQuery): Paginator
    {
        $query = $this->entityRepository->createQueryBuilder('e');

        if (count($httpQuery->filter->companyUuids) > 0) {
            $query->where('e.companyUuid IN (:companyUuids)')
                ->setParameter('companyUuids', $httpQuery->filter->companyUuids);
        }

        return $this->paginator($query, $httpQuery->paginator);
    }

    public function save(Employee $employee): void
    {
        $this->entityRepository->getEntityManager()->persist($employee);
        $this->entityRepository->getEntityManager()->flush();
    }

    public function delete(Employee $employee): void
    {
        $this->entityRepository->getEntityManager()->remove($employee);
        $this->entityRepository->getEntityManager()->flush();
    }
}
