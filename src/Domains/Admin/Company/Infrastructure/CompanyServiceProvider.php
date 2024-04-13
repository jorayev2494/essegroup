<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Company\Infrastructure;

use App\Providers\Domains\AdminDomainServiceProvider;
use Project\Domains\Admin\Company\Domain\Company\CompanyRepositoryInterface;
use Project\Domains\Admin\Company\Domain\Company\LogoRepositoryInterface;
use Project\Domains\Admin\Company\Domain\Company\Services\Logo\Contracts\LogoServiceInterface;
use Project\Domains\Admin\Company\Domain\Company\Services\Logo\LogoService;
use Project\Domains\Admin\Company\Domain\Company\Services\Status\Contracts\StatusServiceInterface;
use Project\Domains\Admin\Company\Domain\Company\Services\Status\StatusService;
use Project\Domains\Admin\Company\Infrastructure\Repositories\Doctrine\Company\CompanyRepository;
use Project\Domains\Admin\Company\Infrastructure\Repositories\Doctrine\Company\LogoRepository;

class CompanyServiceProvider extends AdminDomainServiceProvider
{
    /** @var array<string, string> */
    protected const SERVICES = [
        CompanyRepositoryInterface::class => [self::SERVICE_BIND, CompanyRepository::class],
        LogoServiceInterface::class => [self::SERVICE_BIND, LogoService::class],
        StatusServiceInterface::class => [self::SERVICE_SINGLETON, StatusService::class],
        LogoRepositoryInterface::class => [self::SERVICE_SINGLETON, LogoRepository::class],
    ];

    /** @var array<array-key, string> */
    protected const QUERY_HANDLERS = [
        // Company
        \Project\Domains\Admin\Company\Application\Company\Queries\Index\QueryHandler::class,
        \Project\Domains\Admin\Company\Application\Company\Queries\Show\QueryHandler::class,
        \Project\Domains\Admin\Company\Application\Company\Queries\List\QueryHandler::class,
    ];

    /** @var array<array-key, string> */
    protected const COMMAND_HANDLERS = [
        // Company
        \Project\Domains\Admin\Company\Application\Company\Commands\Create\CommandHandler::class,
        \Project\Domains\Admin\Company\Application\Company\Commands\Update\CommandHandler::class,
        \Project\Domains\Admin\Company\Application\Company\Commands\Delete\CommandHandler::class,
    ];

    /** @var array<array-key, string> */
    protected const DOMAIN_EVENT_SUBSCRIBERS = [
        // \Project\Domains\Admin\Company\Application\Company\Subsribers\Company\CompanyLogoWasDeletedDomainEventSubscriber::class,
    ];

    /** @var array<string, string> */
    protected const ENTITY_TYPES = [
        // Company
        \Project\Domains\Admin\Company\Infrastructure\Repositories\Doctrine\Company\Types\UuidType::class,
        \Project\Domains\Admin\Company\Infrastructure\Repositories\Doctrine\Company\Types\NameType::class,
        \Project\Domains\Admin\Company\Infrastructure\Repositories\Doctrine\Company\Types\DomainType::class,
        \Project\Domains\Admin\Company\Infrastructure\Repositories\Doctrine\Company\Types\EmailType::class,

        // Status
        \Project\Domains\Admin\Company\Infrastructure\Repositories\Doctrine\Status\Types\ValueType::class,
        \Project\Domains\Admin\Company\Infrastructure\Repositories\Doctrine\Status\Types\NoteType::class,
        \Project\Domains\Admin\Company\Infrastructure\Repositories\Doctrine\Status\Types\UuidType::class,
    ];

    /** @var array<array-key, string> */
    protected const MIGRATION_PATHS = [
        'Project\Domains\Admin\Country\Infrastructure\Repositories\Doctrine\Migrations' => __DIR__ . '/Repositories/Doctrine/Migrations',
    ];

    /** @var array<string, string> */
    protected const ENTITY_PATHS = [
        __DIR__ . '/../Domain/Company',
        __DIR__ . '/../Domain/Company/ValueObjects',
        __DIR__ . '/../Domain/Status',
    ];

    /** @var array<string, string> */
    protected const ROUTE_PATHS = [
        [
            'middleware' => ['api', 'auth:admin'],
            'prefix' => 'api/admin',
            'path' => __DIR__ . '/../Presentation/Http/API/REST/routes.php',
        ],
    ];
}
