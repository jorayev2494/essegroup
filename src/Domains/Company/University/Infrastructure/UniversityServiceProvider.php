<?php

declare(strict_types=1);

namespace Project\Domains\Company\University\Infrastructure;

use App\Providers\Domains\AdminDomainServiceProvider;
use Project\Domains\Company\University\Domain\Aplication\Services\ApplicationService;
use Project\Domains\Company\University\Domain\Aplication\Services\Contracts\ApplicationServiceInterface;
use Project\Domains\Company\University\Domain\ApplicationStatusValue\Services\ApplicationStatusValueService;
use Project\Domains\Company\University\Domain\ApplicationStatusValue\Services\Contracts\ApplicationStatusValueServiceInterface;
use Project\Domains\Company\University\Domain\Department\Services\Contracts\DepartmentServiceInterface;
use Project\Domains\Company\University\Domain\Department\Services\DepartmentService;

class UniversityServiceProvider extends AdminDomainServiceProvider
{
    /** @var array<string, string> */
    protected const SERVICES = [
        ApplicationServiceInterface::class => [self::SERVICE_SINGLETON, ApplicationService::class],
        ApplicationStatusValueServiceInterface::class => [self::SERVICE_SINGLETON, ApplicationStatusValueService::class],
        DepartmentServiceInterface::class => [self::SERVICE_SINGLETON, DepartmentService::class],
    ];

    /** @var array<array-key, string> */
    protected const QUERY_HANDLERS = [
        // Application
        \Project\Domains\Company\University\Application\Application\Queries\Index\QueryHandler::class,
        \Project\Domains\Company\University\Application\Application\Queries\ByStudentUuid\QueryHandler::class,
        \Project\Domains\Company\University\Application\Application\Queries\Show\QueryHandler::class,

        // ApplicationStatusValue
        \Project\Domains\Company\University\Application\ApplicationStatusValue\Queries\List\QueryHandler::class,
        \Project\Domains\Company\University\Application\ApplicationStatusValue\Queries\WidgetList\QueryHandler::class,

        // Department
        \Project\Domains\Company\University\Application\Department\Queries\Index\QueryHandler::class
    ];

    /** @var array<array-key, string> */
    protected const COMMAND_HANDLERS = [
        // Application
        \Project\Domains\Company\University\Application\Application\Commands\Create\CommandHandler::class,
        \Project\Domains\Company\University\Application\Application\Commands\Update\CommandHandler::class,
    ];

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
            'middleware' => ['api', 'auth:company'],
            'prefix' => 'api/company',
            'path' => __DIR__ . '/../Presentation/Http/API/REST/routes.php',
        ],
    ];
}
