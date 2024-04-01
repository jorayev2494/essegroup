<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Country\Infrastructure\City\Repositories\Doctrine;

use Project\Domains\Admin\Country\Application\City\Queries\Index\Query;
use Project\Domains\Admin\Country\Domain\City\City;
use Project\Domains\Admin\Country\Domain\City\CityCollection;
use Project\Domains\Admin\Country\Domain\City\CityRepositoryInterface;
use Project\Domains\Admin\Country\Domain\City\ValueObjects\Uuid;
use Project\Domains\Admin\Country\Infrastructure\City\Filters\QueryFilter;
use Project\Shared\Infrastructure\Repository\Contracts\BaseAdminEntityRepository;
use Project\Shared\Infrastructure\Repository\Doctrine\Paginator;

class CityRepository extends BaseAdminEntityRepository implements CityRepositoryInterface
{
    protected function getEntity(): string
    {
        return City::class;
    }

    public function findByUuid(Uuid $uuid): ?City
    {
        return $this->entityRepository->find($uuid);
    }

    public function paginate(Query $queryData): Paginator
    {
        $query = $this->entityRepository->createQueryBuilder('c');

        return $this->paginator($query->getQuery(), $queryData->paginator);
    }

    public function list(QueryFilter $filter): CityCollection
    {
        $query = $this->entityRepository->createQueryBuilder('c');

        if (count($filter->countryUuids) > 0) {
            $query->andWhere('c.countryUuid LIKE :countryUuids')
                ->setParameter('countryUuids', $filter->countryUuids);
        }

        return new CityCollection($query->getQuery()->getResult());
    }

    public function save(City $city): void
    {
        $this->entityRepository->getEntityManager()->persist($city);
        $this->entityRepository->getEntityManager()->flush();
    }

    public function delete(City $city): void
    {
        $this->entityRepository->getEntityManager()->remove($city);
        $this->entityRepository->getEntityManager()->flush();
    }
}
