<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Contest\Infrastructure\WinnerStudent\Repositories\Doctrine;

use Project\Domains\Admin\Contest\Application\WonStudent\Queries\Index\Query;
use Project\Domains\Admin\Contest\Domain\WonStudent\ValueObjects\Code;
use Project\Domains\Admin\Contest\Domain\WonStudent\WonStudent;
use Project\Domains\Admin\Contest\Domain\WonStudent\WonStudentRepositoryInterface;
use Project\Shared\Infrastructure\Repository\Contracts\BaseAdminEntityRepository;
use Project\Shared\Infrastructure\Repository\Doctrine\Paginator;

class WonStudentRepository extends BaseAdminEntityRepository implements WonStudentRepositoryInterface
{
    protected function getEntity(): string
    {
        return WonStudent::class;
    }

    public function paginate(Query $httpQuery): Paginator
    {
        $query = $this->entityRepository->createQueryBuilder('w');

        $query->where('w.contestUuid = :contestUuid')
            ->setParameter('contestUuid', $httpQuery->getContestUuid());

        return $this->paginator($query, $httpQuery->paginator);
    }

    public function findByCode(Code $code): ?WonStudent
    {
        return $this->entityRepository->find($code);
    }

    public function save(WonStudent $wonStudent): void
    {
        $this->entityRepository->getEntityManager()->persist($wonStudent);
        $this->entityRepository->getEntityManager()->flush();
    }
}
