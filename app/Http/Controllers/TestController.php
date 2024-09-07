<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Contracts\Routing\ResponseFactory;
use Project\Infrastructure\Services\Auth\AuthManager;
use Project\Infrastructure\Services\Notification\Contracts\NotificationServiceInterface;
use Project\Infrastructure\Services\Notification\Drivers\WSNotificationDriver;
use Project\Infrastructure\Services\WS\Contracts\WSServiceInterface;
use Symfony\Component\HttpFoundation\Response;

class TestController extends Controller
{
    public function __construct(
        private readonly ResponseFactory $response
    ) { }

    public function centrifuge(WSServiceInterface $WSService): Response
    {
        $WSService->publish('health', [
            'message' => 'Check health',
            'key' => 'value-' . ((string) random_int(100, 500)),
        ]);

        return $this->response->noContent();
    }

    public function notification(NotificationServiceInterface $notificationService): Response
    {
        $notificationService->notify(
            new WSNotificationDriver(
                AuthManager::manager(),
                [
                    'title' => 'WS title',
                    'message' => 'WS message',
                ]
            )
        );

        return $this->response->noContent();
    }
}
