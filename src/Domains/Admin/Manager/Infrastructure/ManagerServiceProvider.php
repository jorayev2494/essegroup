<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Infrastructure;

use App\Providers\Domains\AdminDomainServiceProvider;
use Project\Domains\Admin\Manager\Domain\Manager\Services\Avatar\Contracts\AvatarServiceInterface;
use Project\Domains\Admin\Manager\Domain\Manager\Services\Avatar\AvatarService;

class ManagerServiceProvider extends AdminDomainServiceProvider
{
    /** @var array<string, string> */
    protected const SERVICES = [
        AvatarServiceInterface::class => [self::SERVICE_BIND, AvatarService::class],
    ];

    /** @var array<array-key, string> */
    protected const QUERY_HANDLERS = [
        \Project\Domains\Admin\Manager\Application\Manager\Queries\Index\QueryHandler::class,
        \Project\Domains\Admin\Manager\Application\Manager\Queries\List\QueryHandler::class,
        \Project\Domains\Admin\Manager\Application\Manager\Queries\Show\QueryHandler::class,
    ];

    /** @var array<array-key, string> */
    protected const COMMAND_HANDLERS = [
        \Project\Domains\Admin\Manager\Application\Manager\Commands\Create\CommandHandler::class,
        \Project\Domains\Admin\Manager\Application\Manager\Commands\Update\CommandHandler::class,
        \Project\Domains\Admin\Manager\Application\Manager\Commands\Delete\CommandHandler::class,
    ];

    /** @var array<array-key, string> */
    protected const DOMAIN_EVENT_SUBSCRIBERS = [
        \Project\Domains\Admin\Manager\Application\Manager\Subscribers\ManagerWasCreatedDomainEventSubscriber::class,

        // Restore
        \Project\Domains\Admin\Manager\Application\Manager\Subscribers\Auth\RestorePassword\ManagerRestorePasswordLinkWasAddedDomainEventSubscriber::class,
    ];

    /** @var array<string, string> */
    protected const ENTITY_TYPES = [
        \Project\Domains\Admin\Manager\Infrastructure\Manager\Repositories\Doctrine\Types\UuidType::class,
        \Project\Domains\Admin\Manager\Infrastructure\Manager\Repositories\Doctrine\Types\FirstNameType::class,
        \Project\Domains\Admin\Manager\Infrastructure\Manager\Repositories\Doctrine\Types\LastNameType::class,
        \Project\Domains\Admin\Manager\Infrastructure\Manager\Repositories\Doctrine\Types\EmailType::class,
        \Project\Domains\Admin\Manager\Infrastructure\Manager\Repositories\Doctrine\Types\PasswordType::class,
    ];

    /** @var array<array-key, string> */
    protected const MIGRATION_PATHS = [
        // 'Project\Domains\Admin\Country\Infrastructure\Repositories\Doctrine\Migrations' => __DIR__ . '/Repositories/Doctrine/Migrations',
    ];

    /** @var array<string, string> */
    protected const ENTITY_PATHS = [
        __DIR__ . '/../Domain/Manager',
    ];

    /** @var array<string, string> */
    protected const ROUTE_PATHS = [
        [
            'middleware' => ['api', 'auth:admin'],
            'prefix' => 'api/admin/managers',
            'path' => __DIR__ . '/../Presentation/Http/API/REST/routes.php',
        ],
    ];
}
