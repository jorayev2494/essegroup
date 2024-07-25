<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Infrastructure;

use App\Providers\Domains\AdminDomainServiceProvider;
use Project\Domains\Admin\Manager\Domain\Manager\Services\Avatar\Contracts\AvatarServiceInterface;
use Project\Domains\Admin\Manager\Domain\Manager\Services\Avatar\AvatarService;
use Project\Domains\Admin\Manager\Domain\Permission\PermissionRepositoryInterface;
use Project\Domains\Admin\Manager\Domain\Role\RoleRepositoryInterface;
use Project\Domains\Admin\Manager\Domain\Role\Services\Contracts\RolePermissionServiceInterface;
use Project\Domains\Admin\Manager\Domain\Role\Services\RolePermissionService;
use Project\Domains\Admin\Manager\Infrastructure\Permission\Repositories\Doctrine\PermissionRepository;
use Project\Domains\Admin\Manager\Infrastructure\Role\Repositories\Doctrine\RoleRepository;

class ManagerServiceProvider extends AdminDomainServiceProvider
{
    /** @var array<string, string> */
    protected const SERVICES = [
        AvatarServiceInterface::class => [self::SERVICE_BIND, AvatarService::class],
        RoleRepositoryInterface::class => [self::SERVICE_BIND, RoleRepository::class],
        RolePermissionServiceInterface::class => [self::SERVICE_BIND, RolePermissionService::class],
        PermissionRepositoryInterface::class => [self::SERVICE_BIND, PermissionRepository::class],
    ];

    /** @var array<array-key, string> */
    protected const COMMAND_HANDLERS = [
        \Project\Domains\Admin\Manager\Application\Manager\Commands\Create\CommandHandler::class,
        \Project\Domains\Admin\Manager\Application\Manager\Commands\Update\CommandHandler::class,
        \Project\Domains\Admin\Manager\Application\Manager\Commands\Delete\CommandHandler::class,

        // Role
        \Project\Domains\Admin\Manager\Application\Role\Commands\Create\CommandHandler::class,
        \Project\Domains\Admin\Manager\Application\Role\Commands\Update\CommandHandler::class,
        \Project\Domains\Admin\Manager\Application\Role\Commands\Delete\CommandHandler::class,
        \Project\Domains\Admin\Manager\Application\Role\Commands\UpdatePermissions\CommandHandler::class,

        // Permission
        \Project\Domains\Admin\Manager\Application\Permission\Commands\Create\CommandHandler::class,
        \Project\Domains\Admin\Manager\Application\Permission\Commands\Update\CommandHandler::class,
    ];

    /** @var array<array-key, string> */
    protected const QUERY_HANDLERS = [
        \Project\Domains\Admin\Manager\Application\Manager\Queries\Index\QueryHandler::class,
        \Project\Domains\Admin\Manager\Application\Manager\Queries\List\QueryHandler::class,
        \Project\Domains\Admin\Manager\Application\Manager\Queries\Show\QueryHandler::class,

        // Role
        \Project\Domains\Admin\Manager\Application\Role\Queries\Index\QueryHandler::class,
        \Project\Domains\Admin\Manager\Application\Role\Queries\Show\QueryHandler::class,
        \Project\Domains\Admin\Manager\Application\Role\Queries\List\QueryHandler::class,

        // Permission
        \Project\Domains\Admin\Manager\Application\Permission\Queries\Index\QueryHandler::class,
        \Project\Domains\Admin\Manager\Application\Permission\Queries\List\QueryHandler::class,
        \Project\Domains\Admin\Manager\Application\Permission\Queries\Show\QueryHandler::class,
        \Project\Domains\Admin\Manager\Application\Permission\Queries\GetPermissionsByRoleUuid\QueryHandler::class,
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

        // Role
        \Project\Domains\Admin\Manager\Infrastructure\Role\Repositories\Doctrine\Types\UuidType::class,
        \Project\Domains\Admin\Manager\Infrastructure\Role\Repositories\Doctrine\Types\NameType::class,

        // Permission
        \Project\Domains\Admin\Manager\Infrastructure\Permission\Repositories\Doctrine\Types\IdType::class,
        \Project\Domains\Admin\Manager\Infrastructure\Permission\Repositories\Doctrine\Types\ActionType::class,
        \Project\Domains\Admin\Manager\Infrastructure\Permission\Repositories\Doctrine\Types\LabelType::class,
        \Project\Domains\Admin\Manager\Infrastructure\Permission\Repositories\Doctrine\Types\ResourceType::class,
    ];

    /** @var array<array-key, string> */
    protected const MIGRATION_PATHS = [
        // 'Project\Domains\Admin\Country\Infrastructure\Repositories\Doctrine\Migrations' => __DIR__ . '/Repositories/Doctrine/Migrations',
    ];

    /** @var array<string, string> */
    protected const ENTITY_PATHS = [
        __DIR__ . '/../Domain/Manager',
        __DIR__ . '/../Domain/Role',
        __DIR__ . '/../Domain/Permission',
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
