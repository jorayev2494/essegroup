<?php

declare(strict_types=1);

namespace Project\Domains\Company\Company\Infrastructure;

use App\Providers\Domains\CompanyDomainServiceProvider;
use Project\Domains\Company\Company\Domain\Company\CompanyRepositoryInterface;
use Project\Domains\Company\Company\Domain\Company\Services\Logo\Contracts\LogoServiceInterface;
use Project\Domains\Company\Company\Domain\Company\Services\Logo\LogoService;
use Project\Domains\Company\Company\Infrastructure\Repositories\Doctrine\Company\CompanyRepository;

class CompanyServiceProvider extends CompanyDomainServiceProvider
{
    /** @var array<string, string> */
    protected const SERVICES = [
        CompanyRepositoryInterface::class => [self::SERVICE_BIND, CompanyRepository::class],
        LogoServiceInterface::class => [self::SERVICE_BIND, LogoService::class],
    ];

    /** @var array<array-key, string> */
    protected const QUERY_HANDLERS = [
        // Company
        \Project\Domains\Company\Company\Application\Company\Queries\Show\QueryHandler::class,
    ];

    /** @var array<array-key, string> */
    protected const COMMAND_HANDLERS = [
        // Company
        \Project\Domains\Company\Company\Application\Company\Commands\Update\CommandHandler::class,
    ];

    /** @var array<array-key, string> */
    protected const DOMAIN_EVENT_SUBSCRIBERS = [
        \Project\Domains\Company\Company\Application\Company\Subscribers\CompanyWasCreatedDomainEventSubscriber::class,
        \Project\Domains\Company\Company\Application\Company\Subscribers\CompanyWasDeletedDomainEventSubscriber::class,
    ];

    /** @var array<string, string> */
    protected const ENTITY_TYPES = [
        // Company
        \Project\Domains\Company\Company\Infrastructure\Repositories\Doctrine\Company\Types\UuidType::class,
        \Project\Domains\Company\Company\Infrastructure\Repositories\Doctrine\Company\Types\NameType::class,
        \Project\Domains\Company\Company\Infrastructure\Repositories\Doctrine\Company\Types\EmailType::class,
        \Project\Domains\Company\Company\Infrastructure\Repositories\Doctrine\Company\Types\DomainType::class,

        // Status
        \Project\Domains\Company\Company\Infrastructure\Repositories\Doctrine\Status\Types\ValueType::class,
        \Project\Domains\Company\Company\Infrastructure\Repositories\Doctrine\Status\Types\NoteType::class,
    ];

    /** @var array<array-key, string> */
    protected const MIGRATION_PATHS = [
        'Project\Domains\Company\Country\Infrastructure\Repositories\Doctrine\Migrations' => __DIR__ . '/Repositories/Doctrine/Migrations',
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
            'middleware' => ['api', 'auth:company'],
            'prefix' => 'api/company',
            'path' => __DIR__ . '/../Presentation/Http/API/REST/routes.php',
        ],
    ];
}
