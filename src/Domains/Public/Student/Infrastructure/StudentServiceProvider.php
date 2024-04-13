<?php

declare(strict_types=1);

namespace Project\Domains\Public\Student\Infrastructure;

use App\Providers\Domains\ClientDomainServiceProvider;
use Project\Domains\Public\Student\Domian\Student\Services\Contracts\StudentServiceInterface;
use Project\Domains\Public\Student\Domian\Student\Services\StudentService;

class StudentServiceProvider extends ClientDomainServiceProvider
{
    /** @var array<string, string> */
    protected const SERVICES = [
        StudentServiceInterface::class => [self::SERVICE_BIND, StudentService::class],
    ];

    /** @var array<array-key, string> */
    protected const QUERY_HANDLERS = [];

    /** @var array<array-key, string> */
    protected const COMMAND_HANDLERS = [
        \Project\Domains\Public\Student\Application\Commands\Create\CommandHandler::class,
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
            'middleware' => ['api'],
            'prefix' => 'api/public/students',
            'path' => __DIR__ . '/../Presentation/Http/API/REST/routes.php',
        ],
    ];
}
