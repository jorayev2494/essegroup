<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Infrastructure\Country\Repositories\Doctrine;

use Project\Domains\Admin\University\Application\Country\Queries\Index\Query;
use Project\Domains\Admin\University\Domain\Country\Country;
use Project\Domains\Admin\University\Domain\Country\CountryCollection;
use Project\Domains\Admin\University\Domain\Country\CountryRepositoryInterface;
use Project\Domains\Admin\University\Infrastructure\Country\Filters\HttpQueryFilterDTO;
use Project\Shared\Infrastructure\Repository\Contracts\BaseAdminEntityRepository;
use Project\Shared\Infrastructure\Repository\Doctrine\Paginator;

class CountryRepository extends BaseAdminEntityRepository implements CountryRepositoryInterface
{
    #[\Override]
    protected function getEntity(): string
    {
        return Country::class;
    }

    public function findByUuid(string $uuid): ?Country
    {
        return $this->entityRepository->find($uuid);
    }

    public function paginate(Query $httpQuery): Paginator
    {
        $query = $this->entityRepository->createQueryBuilder('c');

        if ($httpQuery->httpQueryFilter->companyUuid !== null) {
            $query->andWhere('c.companyUuid = :companyUuid')
                ->setParameter('companyUuid', $httpQuery->httpQueryFilter->companyUuid);
        }

        return $this->paginator($query, $httpQuery->paginatorHttpQueryParams);
    }

    public function list(HttpQueryFilterDTO $queryFilterDTO): CountryCollection
    {
        $query = $this->entityRepository->createQueryBuilder('c');

        $query->where('c.isActive = :isActive')
            ->setParameter('isActive', true);

        if ($queryFilterDTO->companyUuid !== null) {
            $query->andWhere('c.companyUuid = :companyUuid')
                ->setParameter('companyUuid', $queryFilterDTO->companyUuid);
        }

        return new CountryCollection($query->getQuery()->getResult());
    }

    public function save(Country $country): void
    {
        $this->entityRepository->getEntityManager()->persist($country);
        $this->entityRepository->getEntityManager()->flush();
    }
}
