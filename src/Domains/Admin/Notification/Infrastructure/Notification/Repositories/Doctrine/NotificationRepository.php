<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Notification\Infrastructure\Notification\Repositories\Doctrine;

use Doctrine\ORM\Query\Expr\Join;
use Project\Domains\Admin\Notification\Application\Notification\Queries\Index\Query as IndexQuery;
use Project\Domains\Admin\Notification\Domain\Manager\ValueObjects\Uuid as ManagerUuid;
use Project\Domains\Admin\Notification\Domain\Notification\Notification;
use Project\Domains\Admin\Notification\Domain\Notification\NotificationRepositoryInterface;
use Project\Domains\Admin\Notification\Domain\Notification\ValueObjects\Uuid;
use Project\Shared\Infrastructure\Repository\Contracts\BaseAdminEntityRepository;
use Project\Shared\Infrastructure\Repository\Doctrine\Paginator;

class NotificationRepository extends BaseAdminEntityRepository implements NotificationRepositoryInterface
{
    protected function getEntity(): string
    {
        return Notification::class;
    }

    public function paginate(IndexQuery $httpQuery): Paginator
    {
        $query = $this->entityRepository->createQueryBuilder('n');
        $query->orderBy('n.createdAt', 'DESC');

        return $this->paginator($query, $httpQuery->paginator);
    }

    public function findByUuid(Uuid $uuid): ?Notification
    {
        return $this->entityRepository->find($uuid);
    }

    public function getQualityUnviewed(ManagerUuid $managerUuid): int
    {
        $res = 0;

        $query = $this->entityRepository->createQueryBuilder('n')
             ->select('COUNT(n.uuid)')
             ->innerJoin('n.viewedManagers', 'nvm', Join::WITH, 'nvm.uuid = notification_notifications_managers.notification_uuid')
             // ->setParameter('managerUuid', $managerUuid->value)
             ->getQuery()
             ->getSingleScalarResult();

        return $res;
    }

    public function save(Notification $notification, bool $isFlush = true): void
    {
        $this->entityRepository->getEntityManager()->persist($notification);

        if ($isFlush) {
            $this->entityRepository->getEntityManager()->flush();
        }
    }
}