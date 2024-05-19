<?php

declare(strict_types=1);

namespace Project\Domains\Admin\StaticPage\Infrastructure\StaticPage\Repositories\Doctrine;

use Project\Domains\Admin\StaticPage\Domain\StaticPage\StaticPage;
use Project\Domains\Admin\StaticPage\Domain\StaticPage\StaticPageRepositoryInterface;
use Project\Domains\Admin\StaticPage\Domain\StaticPage\ValueObjects\Slug;
use Project\Domains\Admin\StaticPage\Domain\StaticPage\ValueObjects\Uuid;
use Project\Shared\Infrastructure\Repository\Contracts\BaseAdminEntityRepository;

class StaticPageRepository extends BaseAdminEntityRepository implements StaticPageRepositoryInterface
{
    protected function getEntity(): string
    {
        return StaticPage::class;
    }

    public function findByUuid(Uuid $uuid): ?StaticPage
    {
        return $this->entityRepository->find($uuid);
    }

    public function findBySlug(Slug $slug): ?StaticPage
    {
        return $this->entityRepository->createQueryBuilder('s')
            ->where('s.slug = :slug')
            ->setParameter('slug', $slug->value)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function save(StaticPage $staticPage): void
    {
        $this->entityRepository->getEntityManager()->persist($staticPage);
        $this->entityRepository->getEntityManager()->flush();
    }
}
