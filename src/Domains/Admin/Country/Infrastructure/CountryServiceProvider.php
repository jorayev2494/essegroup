<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Country\Infrastructure;

use App\Providers\Domains\AdminDomainServiceProvider;

class CountryServiceProvider extends AdminDomainServiceProvider
{
    /** @var array<string, string> */
    protected const SERVICES = [
        \Project\Domains\Admin\Country\Domain\Country\CountryRepositoryInterface::class => [self::SERVICE_BIND, \Project\Domains\Admin\Country\Infrastructure\Country\Repositories\Doctrine\CountryRepository::class],
        \Project\Domains\Admin\Country\Domain\City\CityRepositoryInterface::class => [self::SERVICE_BIND, \Project\Domains\Admin\Country\Infrastructure\City\Repositories\Doctrine\CityRepository::class],
    ];

    /** @var array<array-key, string> */
    protected const QUERY_HANDLERS = [
        // Country
        \Project\Domains\Admin\Country\Application\Country\Queries\Index\QueryHandler::class,
        \Project\Domains\Admin\Country\Application\Country\Queries\List\QueryHandler::class,
        \Project\Domains\Admin\Country\Application\Country\Queries\Show\QueryHandler::class,

        //City
        \Project\Domains\Admin\Country\Application\City\Queries\Index\QueryHandler::class,
        \Project\Domains\Admin\Country\Application\City\Queries\List\QueryHandler::class,
        \Project\Domains\Admin\Country\Application\City\Queries\Show\QueryHandler::class,
    ];

    /** @var array<array-key, string> */
    protected const COMMAND_HANDLERS = [
        // Country
        \Project\Domains\Admin\Country\Application\Country\Commands\Update\CommandHandler::class,
        \Project\Domains\Admin\Country\Application\Country\Commands\Create\CommandHandler::class,
        \Project\Domains\Admin\Country\Application\Country\Commands\Delete\CommandHandler::class,

        // City
        \Project\Domains\Admin\Country\Application\City\Commands\Create\CommandHandler::class,
        \Project\Domains\Admin\Country\Application\City\Commands\Update\CommandHandler::class,
        \Project\Domains\Admin\Country\Application\City\Commands\Delete\CommandHandler::class,
    ];

    /** @var array<array-key, string> */
    protected const DOMAIN_EVENT_SUBSCRIBERS = [
        // \Project\Domains\Admin\Country\Application\Country\Subscribers\Company\CompanyWasDeletedDomainEventSubscriber::class,
    ];

    /** @var array<string, string> */
    protected const ENTITY_TYPES = [
        // Country
        \Project\Domains\Admin\Country\Infrastructure\Country\Repositories\Doctrine\Types\UuidType::class,
        \Project\Domains\Admin\Country\Infrastructure\Country\Repositories\Doctrine\Types\ValueType::class,
        \Project\Domains\Admin\Country\Infrastructure\Country\Repositories\Doctrine\Types\ISOType::class,
        \Project\Domains\Admin\Country\Infrastructure\Country\Repositories\Doctrine\Types\CompanyUuidType::class,

        // City
        \Project\Domains\Admin\Country\Infrastructure\City\Repositories\Doctrine\Types\UuidType::class,
        \Project\Domains\Admin\Country\Infrastructure\City\Repositories\Doctrine\Types\CompanyUuidType::class,
        \Project\Domains\Admin\Country\Infrastructure\City\Repositories\Doctrine\Types\ValueType::class,
    ];

    /** @var array<array-key, string> */
    protected const MIGRATION_PATHS = [
        // 'Project\Domains\Admin\Country\Infrastructure\Repositories\Doctrine\Migrations' => __DIR__ . '/Repositories/Doctrine/Migrations',
    ];

    /** @var array<string, string> */
    protected const ENTITY_PATHS = [
        __DIR__ . '/../Domain/Country',
        __DIR__ . '/../Domain/City',
    ];

    /** @var array<string, string> */
    protected const ROUTE_PATHS = [
        [
            'middleware' => 'api',
            'prefix' => 'api/admin',
            'path' => __DIR__ . '/../Presentation/Http/API/REST/routes.php',
        ],

        // [
        //     'middleware' => 'web',
        //     'prefix' => 'admin',
        //     'path' => __DIR__ . '/../Presentation/Http/Web/REST/routes.php',
        // ],
    ];
}
