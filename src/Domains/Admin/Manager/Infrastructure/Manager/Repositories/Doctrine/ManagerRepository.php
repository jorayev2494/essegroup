<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Infrastructure\Manager\Repositories\Doctrine;

use Project\Domains\Admin\Manager\Application\Manager\Queries\Index\Query;
use Project\Domains\Admin\Manager\Domain\Manager\Manager;
use Project\Domains\Admin\Manager\Domain\Manager\ManagerCollection;
use Project\Domains\Admin\Manager\Domain\Manager\ManagerRepositoryInterface;
use Project\Domains\Admin\Manager\Domain\Manager\ValueObjects\Email;
use Project\Domains\Admin\Manager\Domain\Manager\ValueObjects\Uuid;
use Project\Shared\Infrastructure\Repository\Contracts\BaseAdminEntityRepository;
use Project\Shared\Infrastructure\Repository\Doctrine\Paginator;

class ManagerRepository extends BaseAdminEntityRepository implements ManagerRepositoryInterface
{
    public function getEntity(): string
    {
        return Manager::class;
    }

    public function findByUuid(Uuid $uuid): ?Manager
    {
        return $this->entityRepository->find($uuid);
    }

    public function paginate(Query $httpQuery): Paginator
    {
        $query = $this->entityRepository->createQueryBuilder('m');

        return $this->paginator($query, $httpQuery->paginator);
    }

    public function list(): ManagerCollection
    {
        return new ManagerCollection(
            $this->entityRepository->createQueryBuilder('m')
                ->getQuery()
                ->getResult()
        );
    }

    public function findByEmail(Email $email): ?Manager
    {
        return $this->entityRepository->findOneBy(['email' => $email]);
    }

    public function save(Manager $member): void
    {
        $this->entityRepository->getEntityManager()->persist($member);
        $this->entityRepository->getEntityManager()->flush();
    }

    public function delete(Manager $member): void
    {
        $this->entityRepository->getEntityManager()->remove($member);
        $this->entityRepository->getEntityManager()->flush();
    }
}
