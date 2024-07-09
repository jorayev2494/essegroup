<?php

declare(strict_types=1);

namespace Project\Domains\Admin\StaticPage\Infrastructure;

use App\Providers\Domains\AdminDomainServiceProvider;
use Project\Domains\Admin\StaticPage\Domain\StaticPage\Services\Cover\Contracts\CoverServiceInterface;
use Project\Domains\Admin\StaticPage\Domain\StaticPage\Services\Cover\CoverService;
use Project\Domains\Admin\StaticPage\Domain\StaticPage\StaticPageCacheRepositoryInterface;
use Project\Domains\Admin\StaticPage\Domain\StaticPage\StaticPageRepositoryInterface;
use Project\Domains\Admin\StaticPage\Infrastructure\StaticPage\Repositories\Caches\Redis\StaticPageCacheRepository;
use Project\Domains\Admin\StaticPage\Infrastructure\StaticPage\Repositories\Doctrine\StaticPageRepository;

class StaticPageServiceProvider extends AdminDomainServiceProvider
{
    /** @var array<string, string> */
    protected const SERVICES = [
        StaticPageRepositoryInterface::class => [self::SERVICE_SINGLETON, StaticPageRepository::class],
        StaticPageCacheRepositoryInterface::class => [self::SERVICE_SINGLETON, StaticPageCacheRepository::class],
        CoverServiceInterface::class => [self::SERVICE_SINGLETON, CoverService::class],
    ];

    /** @var array<array-key, string> */
    protected const QUERY_HANDLERS = [
        \Project\Domains\Admin\StaticPage\Applicaiton\StaticPage\Queries\Show\QueryHandler::class,
    ];

    /** @var array<array-key, string> */
    protected const COMMAND_HANDLERS = [
        \Project\Domains\Admin\StaticPage\Applicaiton\StaticPage\Commands\Create\CommandHandler::class,
        \Project\Domains\Admin\StaticPage\Applicaiton\StaticPage\Commands\Update\CommandHandler::class,
    ];

    /** @var array<array-key, string> */
    protected const DOMAIN_EVENT_SUBSCRIBERS = [];

    /** @var array<string, string> */
    protected const ENTITY_TYPES = [
        \Project\Domains\Admin\StaticPage\Infrastructure\StaticPage\Repositories\Doctrine\Types\UuidType::class,
        \Project\Domains\Admin\StaticPage\Infrastructure\StaticPage\Repositories\Doctrine\Types\SlugType::class,
        \Project\Domains\Admin\StaticPage\Infrastructure\StaticPage\Repositories\Doctrine\Types\TitleType::class,
        \Project\Domains\Admin\StaticPage\Infrastructure\StaticPage\Repositories\Doctrine\Types\ContentType::class,
    ];

    /** @var array<array-key, string> */
    protected const MIGRATION_PATHS = [
        // 'Project\Domains\Admin\Country\Infrastructure\Repositories\Doctrine\Migrations' => __DIR__ . '/Repositories/Doctrine/Migrations',
    ];

    /** @var array<string, string> */
    protected const ENTITY_PATHS = [
        __DIR__ . '/../Domain/StaticPage',
        __DIR__ . '/../Domain/StaticPage/ValueObjects',
    ];

    /** @var array<string, string> */
    protected const ROUTE_PATHS = [
        [
            'middleware' => ['api', 'auth:admin'],
            'prefix' => 'api/admin/static-pages',
            'path' => __DIR__ . '/../Presentation/Http/API/REST/routes.php',
        ],
    ];
}
