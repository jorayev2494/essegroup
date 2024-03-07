<?php

namespace Project\Domains\Admin\Country\Infrastructure\Country\Repositories\Doctrine;

use Project\Domains\Admin\Company\Domain\Company\ValueObjects\Uuid;
use Project\Domains\Admin\Country\Domain\Country\Country;
use Project\Domains\Admin\Country\Domain\Country\CountryCollection;
use Project\Domains\Admin\Country\Domain\Country\CountryRepositoryInterface;
use Project\Domains\Admin\Country\Domain\Country\ValueObjects\CompanyUuid;
use Project\Domains\Admin\Country\Domain\Country\ValueObjects\Value;
use Project\Domains\Admin\Country\Infrastructure\Country\Filters\HttpQueryFilterDTO;
use Project\Shared\Domain\Bus\Query\BaseHttpQueryParams;
use Project\Shared\Infrastructure\Repository\Contracts\BaseAdminEntityRepository;
use Project\Shared\Infrastructure\Repository\Doctrine\Paginator;

class CountryRepository extends BaseAdminEntityRepository implements CountryRepositoryInterface
{
    public function getEntity(): string
    {
        return Country::class;
    }

    public function list(HttpQueryFilterDTO $httpQueryFilterDTO): CountryCollection
    {
        $query = $this->entityRepository->createQueryBuilder('c');

        $query->where('c.isActive = :isActive')
            ->setParameter('isActive', true);

        if ($httpQueryFilterDTO->companyUuid !== null) {
            $query->andWhere('c.companyUuid = :companyUuid')
                ->setParameter('companyUuid', $httpQueryFilterDTO->companyUuid);
        }

        return new CountryCollection($query->getQuery()->getResult());
    }

    public function paginate(BaseHttpQueryParams $httpQueryParams): Paginator
    {
        $query = $this->entityRepository->createQueryBuilder('c')->getQuery();

        return $this->paginator($query, $httpQueryParams->paginatorHttpQueryParams);
    }

    public function findByValueAndByCompanyUuid(Value $value, CompanyUuid $companyUuid): ?Country
    {
        return $this->entityRepository->createQueryBuilder('c')
            ->where('c.value = :value')
            ->andWhere('c.companyUuid = :companyUuid')
            ->setParameter('value', $value->value)
            ->setParameter('companyUuid', $companyUuid->value)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findByUuidAndByCompanyUuid(string $uuid, CompanyUuid $companyUuid): ?Country
    {
        return $this->entityRepository->createQueryBuilder('c')
            ->where('c.uuid = :uuid')
            ->andWhere('c.companyUuid = :companyUuid')
            ->setParameter('uuid', $uuid)
            ->setParameter('companyUuid', $companyUuid->value)
            ->getQuery()
            ->getSingleResult();
    }

    public function save(Country $country): void
    {
        $this->entityRepository->getEntityManager()->persist($country);
        $this->entityRepository->getEntityManager()->flush();
    }
}
