<?php

namespace Project\Domains\Admin\Currency\Infrastructure;

use App\Providers\Domains\AdminDomainServiceProvider;
use Project\Domains\Admin\Currency\Domain\Currency\CurrencyRepositoryInterface;
use Project\Domains\Admin\Currency\Infrastructure\Currency\Repositories\Doctrine\CurrencyRepository;

class CurrencyServiceProvider extends AdminDomainServiceProvider
{
    /** @var array<string, string> */
    protected const SERVICES = [
        CurrencyRepositoryInterface::class => [self::SERVICE_BIND, CurrencyRepository::class],
    ];

    /** @var array<array-key, string> */
    protected const QUERY_HANDLERS = [
        \Project\Domains\Admin\Currency\Application\Currency\Queries\List\QueryHandler::class,
    ];

    /** @var array<array-key, string> */
    protected const COMMAND_HANDLERS = [
        \Project\Domains\Admin\Currency\Application\Currency\Commands\Create\CommandHandler::class,
    ];

    /** @var array<array-key, string> */
    protected const DOMAIN_EVENT_SUBSCRIBERS = [];

    /** @var array<string, string> */
    protected const ENTITY_TYPES = [
        \Project\Domains\Admin\Currency\Infrastructure\Currency\Repositories\Doctrine\Types\UuidType::class,
        \Project\Domains\Admin\Currency\Infrastructure\Currency\Repositories\Doctrine\Types\CodeType::class,
        \Project\Domains\Admin\Currency\Infrastructure\Currency\Repositories\Doctrine\Types\ValueType::class,
        \Project\Domains\Admin\Currency\Infrastructure\Currency\Repositories\Doctrine\Types\SymbolType::class,
        \Project\Domains\Admin\Currency\Infrastructure\Currency\Repositories\Doctrine\Types\DescriptionType::class,
    ];

    /** @var array<array-key, string> */
    protected const MIGRATION_PATHS = [
        // 'Project\Domains\Admin\Country\Infrastructure\Repositories\Doctrine\Migrations' => __DIR__ . '/Repositories/Doctrine/Migrations',
    ];

    /** @var array<string, string> */
    protected const ENTITY_PATHS = [
        __DIR__ . '/../Domain/Currency',
    ];

    /** @var array<string, string> */
    protected const ROUTE_PATHS = [
        [
            'middleware' => ['api', 'auth:admin'],
            'prefix' => 'api/admin/currencies',
            'path' => __DIR__ . '/../Presentation/Http/API/REST/routes.php',
        ],
    ];
}
