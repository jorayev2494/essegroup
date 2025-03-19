<?php

namespace Project\Domains\Admin\University\Infrastructure\EmailApplication\Repositories\Doctrine;

use Project\Domains\Admin\University\Domain\EmailApplication\EmailApplication;
use Project\Domains\Admin\University\Domain\EmailApplication\EmailApplicationRepositoryInterface;
use Project\Shared\Infrastructure\Repository\Contracts\BaseAdminEntityRepository;

class EmailApplicationRepository extends BaseAdminEntityRepository implements EmailApplicationRepositoryInterface
{
    protected function getEntity(): string
    {
        return EmailApplication::class;
    }

    public function save(EmailApplication $emailApplication): void
    {
        $this->entityRepository->getEntityManager()->persist($emailApplication);
        $this->entityRepository->getEntityManager()->flush();
    }
}