<?php

declare(strict_types=1);

namespace Project\Domains\Student\Contest\Infrastructure;

use App\Providers\Domains\AdminDomainServiceProvider;
use Project\Domains\Student\Contest\Domain\Contest\Services\ContestService;
use Project\Domains\Student\Contest\Domain\Contest\Services\Contracts\ContestServiceInterface;
use Project\Domains\Student\Contest\Domain\WonContest\Services\Contracts\WonStudentServiceInterface;
use Project\Domains\Student\Contest\Domain\WonContest\Services\WonStudentService;

class ContestServiceProvider extends AdminDomainServiceProvider
{
    /** @var array<string, string> */
    protected const SERVICES = [
        ContestServiceInterface::class => [self::SERVICE_SINGLETON, ContestService::class],
        WonStudentServiceInterface::class => [self::SERVICE_SINGLETON, WonStudentService::class],
    ];

    /** @var array<array-key, string> */
    protected const QUERY_HANDLERS = [
        // Contest
        \Project\Domains\Student\Contest\Application\Contest\Queries\Index\QueryHandler::class,
        \Project\Domains\Student\Contest\Application\Contest\Queries\Show\QueryHandler::class,

        // Contest
        \Project\Domains\Student\Contest\Application\WonStudent\Queries\GetByContestAndStudent\QueryHandler::class,
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
            'middleware' => ['api', 'auth:student'],
            'prefix' => 'api/student/contests',
            'path' => __DIR__ . '/../Presentation/Http/API/REST/routes.php',
        ],
    ];
}
