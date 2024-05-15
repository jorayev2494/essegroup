<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Contest\Infrastructure\Contest\Repositories\Doctrine;

use Project\Domains\Admin\Contest\Application\Contest\Queries\Index\Query;
use Project\Domains\Admin\Contest\Domain\Contest\Contest;
use Project\Domains\Admin\Contest\Domain\Contest\ContestRepositoryInterface;
use Project\Domains\Admin\Contest\Domain\Contest\ValueObjects\Uuid;
use Project\Shared\Infrastructure\Repository\Contracts\BaseAdminEntityRepository;
use Project\Shared\Infrastructure\Repository\Doctrine\Paginator;

class ContestRepository  extends BaseAdminEntityRepository implements ContestRepositoryInterface
{
    protected function getEntity(): string
    {
        return Contest::class;
    }

    public function paginate(Query $httpQuery): Paginator
    {
        $query = $this->entityRepository->createQueryBuilder('c');

        return $this->paginator($query, $httpQuery->paginator);
    }

    public function findByUuid(Uuid $uuid): ?Contest
    {
        return $this->entityRepository->find($uuid);
    }

    public function save(Contest $contest): void
    {
        $this->entityRepository->getEntityManager()->persist($contest);
        $this->entityRepository->getEntityManager()->flush();
    }

    public function delete(Contest $contest): void
    {
        $this->entityRepository->getEntityManager()->remove($contest);
        $this->entityRepository->getEntityManager()->flush();
    }
}
