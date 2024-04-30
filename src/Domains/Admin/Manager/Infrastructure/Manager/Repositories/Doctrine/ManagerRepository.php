<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Infrastructure\Manager\Repositories\Doctrine;

use Project\Domains\Admin\Manager\Domain\Manager\Manager;
use Project\Domains\Admin\Manager\Domain\Manager\ManagerRepositoryInterface;
use Project\Domains\Admin\Manager\Domain\Manager\ValueObjects\Email;
use Project\Domains\Admin\Manager\Domain\Manager\ValueObjects\Uuid;
use Project\Shared\Infrastructure\Repository\Contracts\BaseAdminEntityRepository;

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

    public function findByEmail(Email $email): ?Manager
    {
        return $this->entityRepository->findOneBy(['email' => $email]);
    }

    public function save(Manager $member): void
    {
        $this->entityRepository->getEntityManager()->persist($member);
        $this->entityRepository->getEntityManager()->flush();
    }
}
