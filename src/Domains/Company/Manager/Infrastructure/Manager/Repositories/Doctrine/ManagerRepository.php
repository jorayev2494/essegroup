<?php

namespace Project\Domains\Company\Manager\Infrastructure\Manager\Repositories\Doctrine;

use Project\Domains\Company\Manager\Domain\Manager\Manager;
use Project\Domains\Company\Manager\Domain\Manager\ManagerCollection;
use Project\Domains\Company\Manager\Domain\Manager\ManagerRepositoryInterface;
use Project\Domains\Company\Manager\Domain\Manager\ValueObjects\CompanyUuid;
use Project\Domains\Company\Manager\Domain\Manager\ValueObjects\Uuid;
use Project\Shared\Infrastructure\Repository\Contracts\BaseCompanyEntityRepository;

class ManagerRepository extends BaseCompanyEntityRepository implements ManagerRepositoryInterface
{
    protected function getEntity(): string
    {
        return Manager::class;
    }

    public function findByUuid(Uuid $uuid): ?Manager
    {
        return $this->entityRepository->find($uuid);
    }

    public function findManyByCompanyUuid(CompanyUuid $companyUuid): ManagerCollection
    {
        return new ManagerCollection(
            $this->entityRepository->createQueryBuilder('m')
                ->where('m.companyUuid = :companyUuid')
                ->setParameter('companyUuid', $companyUuid)
                ->getQuery()
                ->getResult()
        );
    }

    public function save(Manager $manager): void
    {
        $this->entityRepository->getEntityManager()->persist($manager);
        $this->entityRepository->getEntityManager()->flush();
    }

    public function delete(Manager $manager): void
    {
        $this->entityRepository->getEntityManager()->remove($manager);
        $this->entityRepository->getEntityManager()->flush();
    }
}
