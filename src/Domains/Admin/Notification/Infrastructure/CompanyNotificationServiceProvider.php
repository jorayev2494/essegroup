<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Notification\Infrastructure;

use App\Providers\Domains\AdminDomainServiceProvider;
use Project\Domains\Admin\Notification\Domain\Manager\ManagerRepositoryInterface;
use Project\Domains\Admin\Notification\Domain\Notification\Contracts\NotificationData;
use Project\Domains\Admin\Notification\Domain\Notification\NotificationRepositoryInterface;
use Project\Domains\Admin\Notification\Domain\Notification\Services\Contracts\NotificationNotifyServiceInterface;
use Project\Domains\Admin\Notification\Domain\Notification\Services\NotificationNotifyService;
use Project\Domains\Admin\Notification\Infrastructure\Manager\Repositories\Doctrine\ManagerRepository;
use Project\Domains\Admin\Notification\Infrastructure\Notification\Repositories\Doctrine\NotificationRepository;
use Project\Domains\Admin\Notification\Domain\CompanyNotification\CompanyNotificationRepositoryInterface;
use Project\Domains\Admin\Notification\Infrastructure\CompanyNotification\Repositories\Doctrine\CompanyNotificationRepository;

class CompanyNotificationServiceProvider extends AdminDomainServiceProvider
{
    /** @var array<string, string> */
    protected const SERVICES = [
        NotificationRepositoryInterface::class => [self::SERVICE_SINGLETON, NotificationRepository::class],
        NotificationNotifyServiceInterface::class => [self::SERVICE_SINGLETON, NotificationNotifyService::class],

        // Company
        CompanyNotificationRepositoryInterface::class => [self::SERVICE_SINGLETON, CompanyNotificationRepository::class],

        // Manager
        ManagerRepositoryInterface::class => [self::SERVICE_SINGLETON, ManagerRepository::class],
    ];

    /** @var array<array-key, string> */
    protected const QUERY_HANDLERS = [
        \Project\Domains\Admin\Notification\Application\Notification\Queries\Index\QueryHandler::class,
        \Project\Domains\Admin\Notification\Application\Notification\Queries\GetQuantityUnviewed\QueryHandler::class,
    ];

    /** @var array<array-key, string> */
    protected const COMMAND_HANDLERS = [
        \Project\Domains\Admin\Notification\Application\Notification\Commands\Create\CommandHandler::class,
        \Project\Domains\Admin\Notification\Application\CompanyNotification\Commands\Create\CommandHandler::class,
        \Project\Domains\Admin\Notification\Application\Notification\Commands\MarkAsViewed\CommandHandler::class,
    ];

    /** @var array<array-key, string> */
    protected const DOMAIN_EVENT_SUBSCRIBERS = [
        \Project\Domains\Admin\Notification\Application\Notification\Subscribers\NotificationWasCreatedDomainEventSubscriber::class,
        // \Project\Domains\Admin\Notification\Application\CompanyNotification\Subscribers\CompanyNotificationWasCreatedDomainEventSubscriber::class,

        // Manager
        \Project\Domains\Admin\Notification\Application\Notification\Subscribers\Manager\ManagerWasCreatedDomainEventSubscriber::class,
        \Project\Domains\Admin\Notification\Application\Notification\Subscribers\Manager\ManagerWasDeletedDomainEventSubscriber::class,
    ];

    /** @var array<string, string> */
    protected const ENTITY_TYPES = [
        // Notification
        \Project\Domains\Admin\Notification\Infrastructure\Notification\Repositories\Doctrine\Types\UuidType::class,
        \Project\Domains\Admin\Notification\Infrastructure\Notification\Repositories\Doctrine\Types\TitleType::class,
        \Project\Domains\Admin\Notification\Infrastructure\Notification\Repositories\Doctrine\Types\PayloadType::class,
        \Project\Domains\Admin\Notification\Infrastructure\Notification\Repositories\Doctrine\Types\TypeType::class,

        // Manager
        \Project\Domains\Admin\Notification\Infrastructure\Manager\Repositories\Doctrine\Types\UuidType::class,

        // Company
        \Project\Domains\Admin\Notification\Infrastructure\CompanyNotification\Repositories\Doctrine\Types\UuidType::class,
        \Project\Domains\Admin\Notification\Infrastructure\CompanyNotification\Repositories\Doctrine\Types\TitleType::class,
        \Project\Domains\Admin\Notification\Infrastructure\CompanyNotification\Repositories\Doctrine\Types\ContentType::class,
        \Project\Domains\Admin\Notification\Infrastructure\CompanyNotification\Repositories\Doctrine\Types\TagType::class,
        \Project\Domains\Admin\Notification\Infrastructure\CompanyNotification\Repositories\Doctrine\Types\CompanyUuidType::class,
    ];

    /** @var array<array-key, string> */
    protected const MIGRATION_PATHS = [
        // 'Project\Domains\Admin\Country\Infrastructure\Repositories\Doctrine\Migrations' => __DIR__ . '/Repositories/Doctrine/Migrations',
    ];

    /** @var array<string, string> */
    protected const ENTITY_PATHS = [
         __DIR__ . '/../Domain/Notification',
         __DIR__ . '/../Domain/Manager',
         // __DIR__ . '/../Domain/CompanyNotification',
    ];

    /** @var array<array-key, string> */
    protected const TRANSLATIONS = [
        // 'src/Domains/Admin/Student/Infrastructure/Student/Translations' => 'project.domains.admin.student.infrastructure.student.translations',
    ];

    /** @var array<string, string> */
    protected const CONFIG_PATHS = [
        // 'key' => 'path',
    ];

    /** @var array<array-key, NotificationData> */
    protected const NOTIFICATIONS = [
        \Project\Domains\Admin\Notification\Infrastructure\Test\DefaultNotificationData::class,
    ];

    /** @var array<string, string> */
    protected const ROUTE_PATHS = [
        [
            'middleware' => ['api', 'auth:admin'],
            'prefix' => 'api/admin',
            'path' => __DIR__ . '/../Presentation/Http/API/REST/routes.php',
        ],

        // [
        //     'middleware' => 'web',
        //     'prefix' => 'admin',
        //     'path' => __DIR__ . '/../Presentation/Http/Web/REST/routes.php',
        // ],
    ];
}