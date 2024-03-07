<?php

declare(strict_types=1);

namespace Project\Domains\Company\Company\Infrastructure\Repositories\Doctrine\Company;

use Project\Domains\Company\Company\Domain\Company\Company;
use Project\Domains\Company\Company\Domain\Company\CompanyRepositoryInterface;
use Project\Domains\Company\Company\Domain\Company\ValueObjects\Domain;
use Project\Domains\Company\Company\Domain\Company\ValueObjects\Name;
use Project\Domains\Company\Company\Domain\Company\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Query\BaseHttpQueryParams;
use Project\Shared\Infrastructure\Repository\Contracts\BaseCompanyEntityRepository;

class CompanyRepository extends BaseCompanyEntityRepository implements CompanyRepositoryInterface
{
    protected function getEntity(): string
    {
        return Company::class;
    }

    #[\Override]
    public function findByUuid(Uuid $uuid): ?Company
    {
        return $this->entityRepository->find($uuid);
    }

    public function paginate(BaseHttpQueryParams $baseHttpQueryParams): array
    {
        $query = $this->entityRepository->createQueryBuilder('c')
            ->getQuery();

        return $this->paginator($query, $baseHttpQueryParams->paginatorHttpQueryParams)->toArray();
    }

    #[\Override]
    public function getAll(): array
    {
        return $this->entityRepository->findAll();
    }

    #[\Override]
    public function findByName(Name $name): ?Company
    {
        return $this->entityRepository->findOneBy(['name' => $name]);
    }

    #[\Override]
    public function findByDomain(Domain $domain): ?Company
    {
        return $this->entityRepository->findOneBy(['domain' => $domain]);
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
        $this->entityRepository->getEntityManager()->flush();
        $this->entityRepository->getEntityManager()->remove($company);
        $this->entityRepository->getEntityManager()->flush();
    }
}
