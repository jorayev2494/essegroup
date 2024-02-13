<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\Company;

use Project\Domains\Admin\University\Domain\Company\Company;
use Project\Domains\Admin\University\Domain\Company\CompanyRepositoryInterface;
use Project\Domains\Admin\University\Domain\Company\ValueObjects\Domain;
use Project\Domains\Admin\University\Domain\Company\ValueObjects\Name;
use Project\Domains\Admin\University\Domain\Company\ValueObjects\Uuid;
use Project\Shared\Infrastructure\Repository\Contracts\BaseAdminEntityRepository;

class CompanyRepository extends BaseAdminEntityRepository implements CompanyRepositoryInterface
{
    protected function getEntity(): string
    {
        return Company::class;
    }

    public function existsByUuid(Uuid $uuid): bool
    {
        return $this->entityRepository->getEntityManager()->createQueryBuilder()
            ->where('uuid = :uuid')
            ->setParameter('uuid', $uuid)
            ->getFirstResult() > 0;
    }

    #[\Override]
    public function findByUuid(Uuid $uuid): ?Company
    {
        return $this->entityRepository->find($uuid);
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
        $this->entityRepository->getEntityManager()->remove($company);
        $this->entityRepository->getEntityManager()->flush();
    }
}
