<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Company\Infrastructure\Repositories\Doctrine\Company;

use Project\Domains\Admin\Company\Application\Company\Queries\Index\Query;
use Project\Domains\Admin\Company\Domain\Company\Company;
use Project\Domains\Admin\Company\Domain\Company\CompanyCollection;
use Project\Domains\Admin\Company\Domain\Company\CompanyRepositoryInterface;
use Project\Domains\Admin\Company\Domain\Company\ValueObjects\Domain;
use Project\Domains\Admin\Company\Domain\Company\ValueObjects\Name;
use Project\Domains\Admin\Company\Domain\Company\ValueObjects\Uuid;
use Project\Shared\Infrastructure\Repository\Contracts\BaseAdminEntityRepository;

class CompanyRepository extends BaseAdminEntityRepository implements CompanyRepositoryInterface
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

    public function paginate(Query $httpQuery): array
    {
        $query = $this->entityRepository->createQueryBuilder('c');

        return $this->paginator($query->getQuery(), $httpQuery->paginator)->toArray();
    }

    #[\Override]
    public function getAll(): array
    {
        return $this->entityRepository->findAll();
    }

    public function list(): CompanyCollection
    {
        return new CompanyCollection(
            $this->entityRepository->findAll()
        );
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
        // $this->entityRepository->getEntityManager()->flush();
        //        $this->entityRepository->getEntityManager()->refresh($company);
        $this->entityRepository->getEntityManager()->persist($company);
        $this->entityRepository->getEntityManager()->flush();
    }

    #[\Override]
    public function delete(Company $company): void
    {
        // $this->entityRepository->getEntityManager()->flush();
        $this->entityRepository->getEntityManager()->remove($company);
        $this->entityRepository->getEntityManager()->flush();
    }
}
