<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Notification\Application\Notification\Queries\Index;

use Project\Domains\Admin\Notification\Application\Notification\Queries\Index\Output\Output;
use Project\Domains\Admin\Notification\Domain\Manager\Manager;
use Project\Domains\Admin\Notification\Domain\Manager\ManagerRepositoryInterface;
use Project\Domains\Admin\Notification\Domain\Manager\ValueObjects\Uuid;
use Project\Domains\Admin\Notification\Domain\Notification\Notification;
use Project\Domains\Admin\Notification\Domain\Notification\NotificationRepositoryInterface;
use Project\Domains\Admin\Notification\Domain\Notification\Services\Contracts\NotificationNotifyServiceInterface;
use Project\Domains\Admin\Notification\Infrastructure\Notification\Adapter\Manager\ManagerAdapter;
use Project\Infrastructure\Services\Auth\AuthManager;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private NotificationRepositoryInterface $repository,
        private ManagerRepositoryInterface $managerRepository,
        private ManagerAdapter $managerAdapter,
        private NotificationNotifyServiceInterface $notificationNotifyService
    ) { }

    public function __invoke(Query $query): Output
    {
        $notifications = $this->repository->paginate($query);

        $viewedManagers = $this->managerAdapter->findMyByUuids(
            $this->getViewedManagersUuids(iterator_to_array($notifications->getItems()))
        );

        // $this->markAsViewed((clone $notifications->getItems())->getArrayCopy());

        return Output::make($notifications, $viewedManagers);
    }

    /**
     * @param array<array-key, Notification> $notifications
     * @return void
     */
    private function markAsViewed(array $notifications): void
    {
        $manager = $this->managerRepository->findByUuid(Uuid::fromValue(AuthManager::managerUuid()->value));

        if ($manager === null || empty($notifications)) {
            return;
        }

        foreach ($notifications as $notification) {
            $this->notificationNotifyService->markAsViewed($notification, $manager);
            $this->repository->save($notification, false);
        }

        $this->repository->flush();
    }

    private function getViewedManagersUuids(array $notifications): array
    {
        /** @var array<array-key, string> $viewedManagersUuids */
        $viewedManagersUuids = array_reduce($notifications, static function (array $res, Notification $notification) use(&$viewedManagerUuids): array {
            $notification->getViewedManagers()->forAll(
                static function (int $idx, Manager $manager) use(&$res, &$viewedManagerUuids): void {
                    if (! in_array($manager->getUuid()->value, $res)) {
                        $res[] = $manager->getUuid()->value;
                    }
                }
            );

            return $res;
        }, []);

        return $viewedManagersUuids;
    }
}