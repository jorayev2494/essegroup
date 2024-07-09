<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Company\Infrastructure\Repositories\Doctrine\Company;

use Project\Domains\Admin\Company\Domain\Company\LogoRepositoryInterface;
use Project\Domains\Admin\Company\Domain\Company\ValueObjects\Logo;
use Project\Shared\Infrastructure\Repository\Contracts\BaseAdminEntityRepository;

class LogoRepository extends BaseAdminEntityRepository implements LogoRepositoryInterface
{

    protected function getEntity(): string
    {
        return Logo::class;
    }

    public function findByUuid(string $uuid): ?Logo
    {
        return $this->entityRepository->find($uuid);
    }

    public function delete(Logo $logo): void
    {
        $this->entityRepository->getEntityManager()->remove($logo);
        $this->entityRepository->getEntityManager()->flush();
    }
}
