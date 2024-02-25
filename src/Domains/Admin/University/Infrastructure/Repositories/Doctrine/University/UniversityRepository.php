<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\University;

use Project\Domains\Admin\University\Domain\University\UniversityCollection;
use Project\Domains\Admin\University\Domain\University\University;
use Project\Domains\Admin\University\Domain\University\UniversityRepositoryInterface;
use Project\Domains\Admin\University\Domain\University\UniversityTranslate;
use Project\Domains\Admin\University\Domain\University\ValueObjects\Uuid;
use Project\Domains\Admin\University\Infrastructure\University\Filters\HttpQueryFilterDTO;
use Project\Shared\Domain\Bus\Query\BaseHttpQueryParams;
use Project\Shared\Infrastructure\Repository\Contracts\BaseAdminEntityRepository;
use Project\Shared\Infrastructure\Repository\Doctrine\Paginator;

class UniversityRepository extends BaseAdminEntityRepository implements UniversityRepositoryInterface
{

    #[\Override]
    protected function getEntity(): string
    {
        return University::class;
    }

    public function get(): UniversityCollection
    {
        return (new UniversityCollection($this->entityRepository->findAll()))->translateItems();
    }

    public function paginate(BaseHttpQueryParams $baseHttpQueryParams): Paginator
    {
        $query = $this->entityRepository->createQueryBuilder('u')
            ->getQuery();

        return $this->paginator($query, $baseHttpQueryParams->paginatorHttpQueryParams);
    }

    public function list(HttpQueryFilterDTO $httpQueryFilterDTO): UniversityCollection
    {
        $query = $this->entityRepository->createQueryBuilder('u');

        if ($httpQueryFilterDTO->companyUuid !== null) {
            $query->where('u.companyUuid = :companyUuid')
                ->setParameter('companyUuid', $httpQueryFilterDTO->companyUuid);
        }

        return new UniversityCollection($query->getQuery()->getResult());
    }

    #[\Override]
    public function findByUuid(Uuid $uuid): ?University
    {
        /** @var University $university */
        $university = $this->entityRepository->find($uuid);

        return UniversityTranslate::execute($university);
    }

    #[\Override]
    public function save(University $university): void
    {
        $this->entityRepository->getEntityManager()->persist($university);
        $this->entityRepository->getEntityManager()->flush();
    }

    #[\Override]
    public function delete(University $university): void
    {
        $this->entityRepository->getEntityManager()->remove($university);
        $this->entityRepository->getEntityManager()->flush();
    }
}
