<?php

declare(strict_types=1);

namespace Project\Domains\Public\University\Infrastructure;

use App\Providers\Domains\AdminDomainServiceProvider;
use Project\Domains\Public\University\Domain\Application\Services\ApplicationService;
use Project\Domains\Public\University\Domain\Application\Services\Contracts\ApplicationServiceInterface;
use Project\Domains\Public\University\Domain\University\UniversityRepositoryInterface;
use Project\Domains\Public\University\Infrastructure\Repositories\Doctrine\University\UniversityRepository;

class UniversityServiceProvider extends AdminDomainServiceProvider
{
    /** @var array<string, string> */
    protected const SERVICES = [
        UniversityRepositoryInterface::class => [self::SERVICE_SINGLETON, UniversityRepository::class],
        ApplicationServiceInterface::class => [self::SERVICE_SINGLETON, ApplicationService::class],
    ];

    /** @var array<array-key, string> */
    protected const QUERY_HANDLERS = [
        \Project\Domains\Public\University\Application\University\Queries\Index\QueryHandler::class,
        \Project\Domains\Public\University\Application\University\Queries\Show\QueryHandler::class,
    ];

    /** @var array<array-key, string> */
    protected const COMMAND_HANDLERS = [
        // Application
        \Project\Domains\Public\University\Application\Application\Commands\Create\CommandHandler::class,
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
            'middleware' => 'api',
            'prefix' => 'api/public',
            'path' => __DIR__ . '/../Presentation/Http/API/REST/routes.php',
        ],
    ];
}
