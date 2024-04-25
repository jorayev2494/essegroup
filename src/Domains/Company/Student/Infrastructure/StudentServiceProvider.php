<?php

declare(strict_types=1);

namespace Project\Domains\Company\Student\Infrastructure;

use App\Providers\Domains\AdminDomainServiceProvider;
use Project\Domains\Company\Student\Domain\Student\Services\Contracts\StudentServiceInterface;
use Project\Domains\Company\Student\Domain\Student\Services\StudentService;

class StudentServiceProvider extends AdminDomainServiceProvider
{
    /** @var array<string, string> */
    protected const SERVICES = [
        StudentServiceInterface::class => [self::SERVICE_BIND, StudentService::class],
    ];

    /** @var array<array-key, string> */
    protected const QUERY_HANDLERS = [
        \Project\Domains\Company\Student\Application\Student\Queries\Index\QueryHandler::class,
        \Project\Domains\Company\Student\Application\Student\Queries\Show\QueryHandler::class,
    ];

    /** @var array<array-key, string> */
    protected const COMMAND_HANDLERS = [
        \Project\Domains\Company\Student\Application\Student\Commands\Create\CommandHandler::class,
        \Project\Domains\Company\Student\Application\Student\Commands\Update\CommandHandler::class,
        \Project\Domains\Company\Student\Application\Student\Commands\Delete\CommandHandler::class,
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
