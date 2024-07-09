<?php

declare(strict_types=1);

namespace Project\Domains\Company\Employee\Infrastructure;

use App\Providers\Domains\AdminDomainServiceProvider;
use Project\Domains\Admin\Company\Domain\Employee\EmployeeRepositoryInterface;
use Project\Domains\Admin\Company\Domain\Employee\Services\Avatar\AvatarService;
use Project\Domains\Admin\Company\Domain\Employee\Services\Avatar\Contracts\AvatarServiceInterface;
use Project\Domains\Admin\Company\Infrastructure\Employee\Repositories\EmployeeRepository;
use Project\Domains\Company\Employee\Domain\Employee\Services\Contracts\EmployeeServiceInterface;
use Project\Domains\Company\Employee\Domain\Employee\Services\EmployeeService;

class EmployeeServiceProvider extends AdminDomainServiceProvider
{
    /** @var array<string, string> */
    protected const SERVICES = [
        EmployeeServiceInterface::class => [self::SERVICE_SINGLETON, EmployeeService::class],
    ];

    /** @var array<array-key, string> */
    protected const QUERY_HANDLERS = [
        \Project\Domains\Company\Employee\Application\Employee\Queries\Index\QueryHandler::class,
        \Project\Domains\Company\Employee\Application\Employee\Queries\Show\QueryHandler::class,
    ];

    /** @var array<array-key, string> */
    protected const COMMAND_HANDLERS = [
        \Project\Domains\Company\Employee\Application\Employee\Commands\Create\CommandHandler::class,
        \Project\Domains\Company\Employee\Application\Employee\Commands\Update\CommandHandler::class,
        \Project\Domains\Company\Employee\Application\Employee\Commands\Delete\CommandHandler::class,
    ];

    /** @var array<array-key, string> */
    protected const DOMAIN_EVENT_SUBSCRIBERS = [];

    /** @var array<string, string> */
    protected const ENTITY_TYPES = [

    ];

    /** @var array<array-key, string> */
    protected const MIGRATION_PATHS = [
        // 'Project\Domains\Admin\Country\Infrastructure\Repositories\Doctrine\Migrations' => __DIR__ . '/Repositories/Doctrine/Migrations',
    ];

    /** @var array<string, string> */
    protected const ENTITY_PATHS = [
         __DIR__ . '/../Domain/Employee',
    ];

    /** @var array<string, string> */
    protected const ROUTE_PATHS = [
        [
            'middleware' => ['api', 'auth:company'],
            'prefix' => 'api/company',
            'path' => __DIR__ . '/../Presentation/Http/API/REST/routes.php',
        ],
    ];
}
