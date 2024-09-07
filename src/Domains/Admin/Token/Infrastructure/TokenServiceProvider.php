<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Token\Infrastructure;

use App\Providers\Domains\AdminDomainServiceProvider;

class TokenServiceProvider extends AdminDomainServiceProvider
{
    /** @var array<string, string> */
    protected const SERVICES = [
        // CurrencyRepositoryInterface::class => [self::SERVICE_BIND, CurrencyRepository::class],
    ];

    /** @var array<array-key, string> */
    protected const QUERY_HANDLERS = [
        \Project\Domains\Admin\Token\Application\Queries\Centrifugo\GenerateConnectionToken\QueryHandler::class,
    ];

    /** @var array<array-key, string> */
    protected const COMMAND_HANDLERS = [

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

    /** @var array<array-key, string> */
    protected const TRANSLATIONS = [
        // 'src/Domains/Admin/Student/Infrastructure/Student/Translations' => 'project.domains.admin.student.infrastructure.student.translations',
    ];

    /** @var array<string, string> */
    protected const CONFIG_PATHS = [
        'token' => __DIR__ . '/config/token.php',
        'tokenP' => __DIR__ . '/config',
    ];

    /** @var array<string, string> */
    protected const ROUTE_PATHS = [
         [
             'middleware' => ['api', 'auth:admin'],
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