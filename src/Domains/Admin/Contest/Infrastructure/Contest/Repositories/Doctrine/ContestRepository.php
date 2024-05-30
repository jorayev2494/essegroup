<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Contest\Infrastructure\Contest\Repositories\Doctrine;

use Doctrine\ORM\Query\Expr\Join;
use Project\Domains\Admin\Contest\Application\Contest\Queries\Index\Query;
use Project\Domains\Admin\Contest\Domain\Contest\Contest;
use Project\Domains\Admin\Contest\Domain\Contest\ContestRepositoryInterface;
use Project\Domains\Admin\Contest\Domain\Contest\ValueObjects\Uuid;
use Project\Domains\Admin\Contest\Domain\WonStudent\WonStudent;
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

        if (count($httpQuery->filter->wonStudentUuids) > 0) {
            $query->innerJoin(WonStudent::class, 'ws', Join::WITH, 'ws.contestUuid = c.uuid')
                ->where('ws.studentUuid IN (:studentUuids)')
                ->setParameter('studentUuids', $httpQuery->filter->wonStudentUuids);
        }

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
