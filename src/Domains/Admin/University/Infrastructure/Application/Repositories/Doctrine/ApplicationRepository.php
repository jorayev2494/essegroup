<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Infrastructure\Application\Repositories\Doctrine;

use Project\Domains\Admin\University\Domain\Application\Application;
use Project\Domains\Admin\University\Domain\Application\ApplicationRepositoryInterface;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Query\BaseHttpQueryParams;
use Project\Shared\Infrastructure\Repository\Contracts\BaseAdminEntityRepository;
use Project\Shared\Infrastructure\Repository\Doctrine\Paginator;

class ApplicationRepository extends BaseAdminEntityRepository implements ApplicationRepositoryInterface
{
    #[\Override]
    protected function getEntity(): string
    {
        return Application::class;
    }

    public function paginate(BaseHttpQueryParams $httpQueryParams): Paginator
    {
        $query = $this->entityRepository->createQueryBuilder('a')->getQuery();

        return $this->paginator($query, $httpQueryParams->paginatorHttpQueryParams);
    }

    public function findByUuid(Uuid $uuid): ?Application
    {
        return $this->entityRepository->find($uuid);
    }

    public function save(Application $application): void
    {
        $this->entityRepository->getEntityManager()->persist($application);
        $this->entityRepository->getEntityManager()->flush();
    }

    public function delete(Application $application): void
    {
        $this->entityRepository->getEntityManager()->remove($application);
        $this->entityRepository->getEntityManager()->flush();
    }
}
