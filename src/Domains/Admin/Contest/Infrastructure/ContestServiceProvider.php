<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Contest\Infrastructure;

use App\Providers\Domains\AdminDomainServiceProvider;
use Project\Domains\Admin\Contest\Domain\Contest\ContestRepositoryInterface;
use Project\Domains\Admin\Contest\Domain\Contest\Services\ContestService;
use Project\Domains\Admin\Contest\Domain\Contest\Services\Contracts\ContestServiceInterface;
use Project\Domains\Admin\Contest\Domain\WonStudent\Services\Contracts\WonStudentServiceInterface;
use Project\Domains\Admin\Contest\Domain\WonStudent\Services\WonStudentService;
use Project\Domains\Admin\Contest\Domain\WonStudent\WonStudentRepositoryInterface;
use Project\Domains\Admin\Contest\Infrastructure\Contest\Repositories\Doctrine\ContestRepository;
use Project\Domains\Admin\Contest\Infrastructure\WinnerStudent\Repositories\Doctrine\WonStudentRepository;

class ContestServiceProvider extends AdminDomainServiceProvider
{
    /** @var array<string, string> */
    protected const SERVICES = [
        ContestRepositoryInterface::class => [self::SERVICE_SINGLETON, ContestRepository::class],
        ContestServiceInterface::class => [self::SERVICE_SINGLETON, ContestService::class],
        WonStudentRepositoryInterface::class => [self::SERVICE_SINGLETON, WonStudentRepository::class],
        WonStudentServiceInterface::class => [self::SERVICE_SINGLETON, WonStudentService::class],
    ];

    /** @var array<array-key, string> */
    protected const QUERY_HANDLERS = [
        // Contest
        \Project\Domains\Admin\Contest\Application\Contest\Queries\Index\QueryHandler::class,
        \Project\Domains\Admin\Contest\Application\Contest\Queries\Show\QueryHandler::class,
        \Project\Domains\Admin\Contest\Application\Contest\Queries\Participants\QueryHandler::class,

        // WonStudent
        \Project\Domains\Admin\Contest\Application\WonStudent\Queries\Index\QueryHandler::class,
        \Project\Domains\Admin\Contest\Application\WonStudent\Queries\Show\QueryHandler::class,
    ];

    /** @var array<array-key, string> */
    protected const COMMAND_HANDLERS = [
        // Contest
        \Project\Domains\Admin\Contest\Application\Contest\Commands\Create\CommandHandler::class,
        \Project\Domains\Admin\Contest\Application\Contest\Commands\Update\CommandHandler::class,
        \Project\Domains\Admin\Contest\Application\Contest\Commands\Delete\CommandHandler::class,

        // WonStudent
        \Project\Domains\Admin\Contest\Application\WonStudent\Commands\Create\CommandHandler::class,
        \Project\Domains\Admin\Contest\Application\WonStudent\Commands\Update\CommandHandler::class,
    ];

    /** @var array<array-key, string> */
    protected const DOMAIN_EVENT_SUBSCRIBERS = [];

    /** @var array<string, string> */
    protected const ENTITY_TYPES = [
        // Contest
        \Project\Domains\Admin\Contest\Infrastructure\Contest\Repositories\Doctrine\Types\UuidType::class,
        \Project\Domains\Admin\Contest\Infrastructure\Contest\Repositories\Doctrine\Types\TitleType::class,
        \Project\Domains\Admin\Contest\Infrastructure\Contest\Repositories\Doctrine\Types\DescriptionType::class,

        // WonStudent
        \Project\Domains\Admin\Contest\Infrastructure\WinnerStudent\Repositories\Doctrine\Types\CodeType::class,
        \Project\Domains\Admin\Contest\Infrastructure\WinnerStudent\Repositories\Doctrine\Types\NoteType::class,
    ];

    /** @var array<array-key, string> */
    protected const MIGRATION_PATHS = [
        // 'Project\Domains\Admin\Country\Infrastructure\Repositories\Doctrine\Migrations' => __DIR__ . '/Repositories/Doctrine/Migrations',
    ];

    /** @var array<string, string> */
    protected const ENTITY_PATHS = [
         __DIR__ . '/../Domain/Contest',
        __DIR__ . '/../Domain/WonStudent',
    ];

    /** @var array<string, string> */
    protected const ROUTE_PATHS = [
        [
            'middleware' => ['api', 'auth:admin'],
            'prefix' => 'api/admin/contests',
            'path' => __DIR__ . '/../Presentation/Http/API/REST/routes.php',
        ],
    ];
}
