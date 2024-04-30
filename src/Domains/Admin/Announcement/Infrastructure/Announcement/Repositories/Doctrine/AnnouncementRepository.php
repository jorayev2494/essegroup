<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Announcement\Infrastructure\Announcement\Repositories\Doctrine;

use Project\Domains\Admin\Announcement\Application\Announcement\Queries\Index\Query as IndexQuery;
use Project\Domains\Admin\Announcement\Application\Announcement\Queries\List\Query as ListQuery;
use Project\Domains\Admin\Announcement\Domain\Announcement\Announcement;
use Project\Domains\Admin\Announcement\Domain\Announcement\AnnouncementCollection;
use Project\Domains\Admin\Announcement\Domain\Announcement\AnnouncementRepositoryInterface;
use Project\Domains\Admin\Announcement\Domain\Announcement\ValueObjects\Uuid;
use Project\Shared\Infrastructure\Repository\Contracts\BaseAdminEntityRepository;
use Project\Shared\Infrastructure\Repository\Doctrine\Paginator;

class AnnouncementRepository extends BaseAdminEntityRepository implements AnnouncementRepositoryInterface
{

    protected function getEntity(): string
    {
        return Announcement::class;
    }

    public function paginate(IndexQuery $httpQuery): Paginator
    {
        $query = $this->entityRepository->createQueryBuilder('a');

        if (count($httpQuery->filter->forItems) > 0) {
            $query->andWhere('a.forItem IN (:forItems)')
                ->setParameter('forItems', $httpQuery->filter->forItems);
        }

        if ($httpQuery->filter->activity !== null) {
            $query->andWhere('a.isActive = :activity')
                ->setParameter('activity', $httpQuery->filter->activity);
        }

        return $this->paginator($query, $httpQuery->paginator);
    }

    public function list(ListQuery $httpQuery): AnnouncementCollection
    {
        $query = $this->entityRepository->createQueryBuilder('a');

        if (count($httpQuery->filter->forItems) > 0) {
            $query->andWhere('a.forItem IN (:forItems)')
                ->setParameter('forItems', $httpQuery->filter->forItems);
        }

        if ($httpQuery->filter->activity !== null) {
            $query->andWhere('a.isActive = :activity')
                ->setParameter('activity', $httpQuery->filter->activity);
        }

        return new AnnouncementCollection($query->getQuery()->getResult());
    }

    public function findByUuid(Uuid $uuid): ?Announcement
    {
        return $this->entityRepository->find($uuid);
    }

    public function save(Announcement $announcement): void
    {
        $this->entityRepository->getEntityManager()->persist($announcement);
        $this->entityRepository->getEntityManager()->flush();
    }

    public function delete(Announcement $announcement): void
    {
        $this->entityRepository->getEntityManager()->remove($announcement);
        $this->entityRepository->getEntityManager()->flush();
    }
}
