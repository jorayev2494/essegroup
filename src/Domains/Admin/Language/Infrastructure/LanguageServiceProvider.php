<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Language\Infrastructure;

use App\Providers\Domains\AdminDomainServiceProvider;
use Project\Domains\Admin\Language\Applications\Language\Queries\Index\QueryHandler;

class LanguageServiceProvider extends AdminDomainServiceProvider
{
    /** @var array<string, string> */
    protected const SERVICES = [
        \Project\Domains\Admin\Language\Domain\Language\LanguageRepositoryInterface::class => [self::SERVICE_BIND, \Project\Domains\Admin\Language\Infrastructure\Language\Repositories\Doctrine\LanguageRepository::class],
    ];

    /** @var array<array-key, string> */
    protected const QUERY_HANDLERS = [
        \Project\Domains\Admin\Language\Applications\Language\Queries\Index\QueryHandler::class,
        \Project\Domains\Admin\Language\Applications\Language\Queries\List\QueryHandler::class,
        \Project\Domains\Admin\Language\Applications\Language\Queries\Show\QueryHandler::class,
    ];

    /** @var array<array-key, string> */
    protected const COMMAND_HANDLERS = [
        \Project\Domains\Admin\Language\Applications\Language\Commands\Create\CommandHandler::class,
        \Project\Domains\Admin\Language\Applications\Language\Commands\Update\CommandHandler::class,
        \Project\Domains\Admin\Language\Applications\Language\Commands\Delete\CommandHandler::class,
    ];

    /** @var array<array-key, string> */
    protected const DOMAIN_EVENT_SUBSCRIBERS = [];

    /** @var array<string, string> */
    protected const ENTITY_TYPES = [
        \Project\Domains\Admin\Language\Infrastructure\Language\Repositories\Doctrine\Types\UuidType::class,
        \Project\Domains\Admin\Language\Infrastructure\Language\Repositories\Doctrine\Types\ISOType::class,
        \Project\Domains\Admin\Language\Infrastructure\Language\Repositories\Doctrine\Types\ValueType::class,
    ];

    /** @var array<array-key, string> */
    protected const MIGRATION_PATHS = [
        // 'Project\Domains\Admin\Country\Infrastructure\Repositories\Doctrine\Migrations' => __DIR__ . '/Repositories/Doctrine/Migrations',
    ];

    /** @var array<string, string> */
    protected const ENTITY_PATHS = [
        __DIR__ . '/../Domain/Language',
    ];

    /** @var array<string, string> */
    protected const ROUTE_PATHS = [
        [
            'middleware' => 'api',
            'prefix' => 'api/admin',
            'path' => __DIR__ . '/../Presentation/Http/API/REST/routes.php',
        ],
    ];

//    public function register(): void
//    {
//        dd(__METHOD__);
//    }
//
//    public function boot(): void
//    {
//        dd(__METHOD__);
//    }
}
