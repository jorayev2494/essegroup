<?php

namespace Project\Domains\Admin\Country\Infrastructure\Country\Repositories\Doctrine;

use Project\Domains\Admin\Country\Application\Country\Queries\Index\Query;
use Project\Domains\Admin\Country\Domain\Country\Country;
use Project\Domains\Admin\Country\Domain\Country\CountryCollection;
use Project\Domains\Admin\Country\Domain\Country\CountryRepositoryInterface;
use Project\Domains\Admin\Country\Domain\Country\ValueObjects\Uuid;
use Project\Domains\Admin\Country\Domain\Country\ValueObjects\Value;
use Project\Domains\Admin\Country\Infrastructure\Country\Filters\QueryFilter;
use Project\Domains\Admin\Country\Infrastructure\Country\Repositories\Doctrine\Filter\FilterPipelineDTO;
use Project\Domains\Admin\Country\Infrastructure\Country\Repositories\Doctrine\Filter\FilterQueryBuilder;
use Project\Shared\Infrastructure\Repository\Contracts\BaseAdminEntityRepository;
use Project\Shared\Infrastructure\Repository\Doctrine\Paginator;

class CountryRepository extends BaseAdminEntityRepository implements CountryRepositoryInterface
{
    public function getEntity(): string
    {
        return Country::class;
    }

    public function list(QueryFilter $httpQueryFilterDTO): CountryCollection
    {
        $query = $this->entityRepository->createQueryBuilder('c');

        FilterQueryBuilder::build(
            new FilterPipelineDTO(
                $query,
                $httpQueryFilterDTO
            )
        );

        return new CountryCollection($query->getQuery()->getResult());
    }

    public function paginate(Query $httpQuery): Paginator
    {
        $query = $this->entityRepository->createQueryBuilder('c');

        return $this->paginator($query->getQuery(), $httpQuery->paginator);
    }

    public function findByUuid(Uuid $uuid): ?Country
    {
        return $this->entityRepository->find($uuid);
    }

    public function findManyByUuids(array $uuids): CountryCollection
    {
        return new CountryCollection(
            $this->entityRepository->createQueryBuilder('c')
                ->where('c.uuid IN (:uuids)')
                ->setParameter('uuids', $uuids)
                ->getQuery()
                ->getResult()
        );
    }

    public function save(Country $country): void
    {
        $this->entityRepository->getEntityManager()->persist($country);
        $this->entityRepository->getEntityManager()->flush();
    }

    public function delete(Country $country): void
    {
        $this->entityRepository->getEntityManager()->remove($country);
        $this->entityRepository->getEntityManager()->flush();
    }
}
