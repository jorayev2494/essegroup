<?php

declare(strict_types=1);

namespace Project\Domains\Public\Manager\Infrastructure;

use App\Providers\Domains\AdminDomainServiceProvider;
use Project\Domains\Public\Manager\Domain\Manager\Services\Contracts\ManagerServiceInterface;
use Project\Domains\Public\Manager\Domain\Manager\Services\ManagerService;

class ManagerServiceProvider extends AdminDomainServiceProvider
{
    /** @var array<string, string> */
    protected const SERVICES = [
        ManagerServiceInterface::class => [self::SERVICE_SINGLETON, ManagerService::class],
    ];

    /** @var array<array-key, string> */
    protected const QUERY_HANDLERS = [
        \Project\Domains\Public\Manager\Application\Manager\Queries\List\QueryHandler::class,
        \Project\Domains\Public\Manager\Application\Manager\Queries\Show\QueryHandler::class,
    ];

    /** @var array<array-key, string> */
    protected const COMMAND_HANDLERS = [];

    /** @var array<array-key, string> */
    protected const DOMAIN_EVENT_SUBSCRIBERS = [];

    /** @var array<string, string> */
    protected const ENTITY_TYPES = [
        // \Project\Domains\Admin\Currency\Infrastructure\Repositories\Doctrine\Currency\Types\UuidType::class,
    ];

    /** @var array<array-key, string> */
    protected const MIGRATION_PATHS = [
        // 'Project\Domains\Admin\Country\Infrastructure\Repositories\Doctrine\Migrations' => __DIR__ . '/Repositories/Doctrine/Migrations',
    ];

    /** @var array<string, string> */
    protected const ENTITY_PATHS = [
        // __DIR__ . '/../Domain',
    ];

    /** @var array<string, string> */
    protected const ROUTE_PATHS = [
        [
            'middleware' => ['api'],
            'prefix' => 'api/public/managers',
            'path' => __DIR__ . '/../Presentation/Http/API/REST/routes.php',
        ],
    ];
}
