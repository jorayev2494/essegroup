<?php

declare(strict_types=1);

namespace Project\Domains\Public\StaticPage\Infrastructure;

use App\Providers\Domains\AdminDomainServiceProvider;
use Project\Domains\Public\StaticPage\Domain\StaticPage\Services\Contracts\StaticPageServiceInterface;
use Project\Domains\Public\StaticPage\Domain\StaticPage\Services\StaticPageService;

class StaticPageServiceProvider extends AdminDomainServiceProvider
{
    /** @var array<string, string> */
    protected const SERVICES = [
        StaticPageServiceInterface::class => [self::SERVICE_SINGLETON, StaticPageService::class],
    ];

    /** @var array<array-key, string> */
    protected const QUERY_HANDLERS = [
        \Project\Domains\Public\StaticPage\Application\StaticPage\Queries\Show\QueryHandler::class,
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
            'prefix' => 'api/public/static-pages',
            'path' => __DIR__ . '/../Presentation/Http/API/REST/routes.php',
        ],
    ];
}
