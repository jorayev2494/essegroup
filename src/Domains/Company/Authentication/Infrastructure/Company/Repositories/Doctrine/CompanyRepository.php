<?php

declare(strict_types=1);

namespace Project\Domains\Company\Authentication\Infrastructure\Company\Repositories\Doctrine;

use Project\Domains\Company\Authentication\Domain\Company\Company;
use Project\Domains\Company\Authentication\Domain\Company\CompanyRepositoryInterface;
use Project\Shared\Infrastructure\Repository\Contracts\BaseCompanyEntityRepository;

class CompanyRepository extends BaseCompanyEntityRepository implements CompanyRepositoryInterface
{
    #[\Override]
    protected function getEntity(): string
    {
        return Company::class;
    }

    public function findByUuid(string $uuid): ?Company
    {
        return $this->entityRepository->find($uuid);
    }

    #[\Override]
    public function save(Company $company): void
    {
        $this->entityRepository->getEntityManager()->persist($company);
        $this->entityRepository->getEntityManager()->flush();
    }

    #[\Override]
    public function delete(Company $company): void
    {
        $this->entityRepository->getEntityManager()->remove($company);
        $this->entityRepository->getEntityManager()->flush();
    }
}
