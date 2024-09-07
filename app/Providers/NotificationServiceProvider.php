<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Project\Domains\Admin\Notification\Domain\Notification\Contracts\NotificationData;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class NotificationServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Entities
        $this->app->singleton('notifications', static fn (): array => []);

        \Illuminate\Foundation\Application::macro('addNotifications', function (array $notifications): void {
            /** @var array<array-key, NotificationData> $notificationCollect */
            $notificationCollect = $this->make('notifications');

            /**
             * @var array<array-key, NotificationData> $notifications
             */
            foreach ($notifications as $className) {
                if (array_key_exists($type = $className::TYPE, $notificationCollect)) {
                    throw new BadRequestHttpException(sprintf('The notification type %s already exists', $type));
                }
                $notificationCollect[$type] = $className;
            }

            $this->app->singleton('notifications', static fn (): array => $notificationCollect);
        });
    }

    public function boot(): void
    {
        //
    }
}
