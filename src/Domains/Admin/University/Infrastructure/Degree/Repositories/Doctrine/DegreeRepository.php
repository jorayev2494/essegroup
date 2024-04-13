<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Infrastructure\Degree\Repositories\Doctrine;

use Project\Domains\Admin\University\Application\Degree\Queries\Index\Query;
use Project\Domains\Admin\University\Domain\Degree\Degree;
use Project\Domains\Admin\University\Domain\Degree\DegreeCollection;
use Project\Domains\Admin\University\Domain\Degree\DegreeRepositoryInterface;
use Project\Domains\Admin\University\Domain\Degree\ValueObjects\Uuid;
use Project\Domains\Admin\University\Infrastructure\Degree\Filters\QueryFilter;
use Project\Domains\Admin\University\Infrastructure\Degree\Repositories\Doctrine\Filter\FilterPipelineDTO;
use Project\Domains\Admin\University\Infrastructure\Degree\Repositories\Doctrine\Filter\FilterQueryBuilder;
use Project\Shared\Infrastructure\Repository\Contracts\BaseAdminEntityRepository;
use Project\Shared\Infrastructure\Repository\Doctrine\Paginator;

class DegreeRepository extends BaseAdminEntityRepository implements DegreeRepositoryInterface
{

    protected function getEntity(): string
    {
        return Degree::class;
    }

    public function paginate(Query $httpQuery): Paginator
    {
        $query = $this->entityRepository->createQueryBuilder('d');

        return $this->paginator($query, $httpQuery->paginator);
    }

    public function list(QueryFilter $filter): DegreeCollection
    {
        $query = $this->entityRepository->createQueryBuilder('d');

        FilterQueryBuilder::build(
            new FilterPipelineDTO(
                $query,
                $filter
            )
        );

        return new DegreeCollection($query->getQuery()->getResult());
    }

    public function findByUuid(Uuid $uuid): ?Degree
    {
        return $this->entityRepository->find($uuid);
    }

    public function findManyByUuids(Uuid ...$uuids): DegreeCollection
    {
        return new DegreeCollection(
            $this->entityRepository->createQueryBuilder('d')
                ->where('d.uuid IN (:uuids)')
                ->setParameter('uuids', array_map(
                    static fn (Uuid $uuid): string => $uuid->value,
                    $uuids
                ))
                ->getQuery()
                ->getResult()
        );
    }

    public function save(Degree $degree): void
    {
        $this->entityRepository->getEntityManager()->persist($degree);
        $this->entityRepository->getEntityManager()->flush();
    }

    public function delete(Degree $degree): void
    {
        $this->entityRepository->getEntityManager()->remove($degree);
        $this->entityRepository->getEntityManager()->flush();
    }
}
