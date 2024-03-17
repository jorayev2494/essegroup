<?php

declare(strict_types=1);

namespace Project\Domains\Company\Company\Infrastructure;

use App\Providers\Domains\CompanyDomainServiceProvider;
use Project\Domains\Company\Company\Domain\Company\Services\Contracts\CompanyServiceInterface;
use Project\Domains\Company\Company\Domain\Company\Services\CompanyService;

class CompanyServiceProvider extends CompanyDomainServiceProvider
{
    /** @var array<string, string> */
    protected const SERVICES = [
        CompanyServiceInterface::class => [self::SERVICE_BIND, CompanyService::class],
    ];

    /** @var array<array-key, string> */
    protected const QUERY_HANDLERS = [
        // Company
        \Project\Domains\Company\Company\Application\Company\Queries\Show\QueryHandler::class,
    ];

    /** @var array<array-key, string> */
    protected const COMMAND_HANDLERS = [
        // Company
        \Project\Domains\Company\Company\Application\Company\Commands\Update\CommandHandler::class,
    ];

    /** @var array<array-key, string> */
    protected const DOMAIN_EVENT_SUBSCRIBERS = [];

    /** @var array<string, string> */
    protected const ENTITY_TYPES = [];

    /** @var array<array-key, string> */
    protected const MIGRATION_PATHS = [
        // 'Project\Domains\Company\Country\Infrastructure\Repositories\Doctrine\Migrations' => __DIR__ . '/Repositories/Doctrine/Migrations',
    ];

    /** @var array<string, string> */
    protected const ENTITY_PATHS = [
        // __DIR__ . '/../Domain/Company',
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
