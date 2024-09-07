<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Notification\Infrastructure\Manager\Repositories\Doctrine;

use Project\Domains\Admin\Notification\Domain\Manager\Manager;
use Project\Domains\Admin\Notification\Domain\Manager\ManagerRepositoryInterface;
use Project\Domains\Admin\Notification\Domain\Manager\ValueObjects\Uuid;
use Project\Shared\Infrastructure\Repository\Contracts\BaseAdminEntityRepository;

class ManagerRepository extends BaseAdminEntityRepository implements ManagerRepositoryInterface
{
    protected function getEntity(): string
    {
        return Manager::class;
    }

    public function findByUuid(Uuid $uuid): ?Manager
    {
        return $this->entityRepository->find($uuid);
    }

    public function save(Manager $manager): void
    {
        $this->entityRepository->getEntityManager()->persist($manager);
        $this->entityRepository->getEntityManager()->flush();
    }

    public function delete(Manager $manager): void
    {
        $this->entityRepository->getEntityManager()->remove($manager);
        $this->entityRepository->getEntityManager()->flush();
    }
}