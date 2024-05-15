<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Infrastructure\Application\Repositories\Doctrine;

use Project\Domains\Admin\University\Application\ApplicationStatusValue\Queries\Index\Query as IndexQuery;
use Project\Domains\Admin\University\Domain\Application\StatusValue;
use Project\Domains\Admin\University\Domain\Application\StatusValueCollection;
use Project\Domains\Admin\University\Domain\Application\StatusValueRepositoryInterface;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\StatusValueUuid;
use Project\Shared\Infrastructure\Repository\Contracts\BaseAdminEntityRepository;
use Project\Shared\Infrastructure\Repository\Doctrine\Paginator;

class StatusValueRepository extends BaseAdminEntityRepository implements StatusValueRepositoryInterface
{
    protected function getEntity(): string
    {
        return StatusValue::class;
    }

    public function paginate(IndexQuery $httpQuery): Paginator
    {
        $query = $this->entityRepository->createQueryBuilder('s');

        return $this->paginator($query, $httpQuery->paginate);
    }

    public function list(): StatusValueCollection
    {
        return new StatusValueCollection(
            $this->entityRepository->createQueryBuilder('s')
                // ->where('s.isFirst = :isFirst')
                // ->setParameter('isFirst', false)
                ->getQuery()
                ->getResult()
        );
    }

    public function findByUuid(StatusValueUuid $uuid): ?StatusValue
    {
        return $this->entityRepository->find($uuid);
    }

    public function findManyByUuids(array $uuids): StatusValueCollection
    {
        return new StatusValueCollection(
            $this->entityRepository->createQueryBuilder('s')
                ->where('s.uuid IN (:uuids)')
                ->setParameter('uuids', $uuids)
                ->getQuery()
                ->getResult()
        );
    }

    public function findFirst(): ?StatusValue
    {
        return $this->entityRepository->createQueryBuilder('s')
            ->where('s.isFirst = :isFirst')
            ->setParameter('isFirst', true)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function save(StatusValue $statusItem): void
    {
        $this->entityRepository->getEntityManager()->persist($statusItem);
        $this->entityRepository->getEntityManager()->flush();
    }

    public function delete(StatusValue $statusItem): void
    {
        $this->entityRepository->getEntityManager()->remove($statusItem);
        $this->entityRepository->getEntityManager()->flush();
    }
}
