<?php

declare(strict_types=1);

namespace Project\Domains\Company\Manager\Infrastructure;

use App\Providers\Domains\CompanyDomainServiceProvider;
use Project\Domains\Company\Manager\Domain\Manager\ManagerRepositoryInterface;
use Project\Domains\Company\Manager\Infrastructure\Manager\Repositories\Doctrine\ManagerRepository;

class ManagerServiceProvider extends CompanyDomainServiceProvider
{
    /** @var array<string, string> */
    protected const SERVICES = [
        ManagerRepositoryInterface::class => [self::SERVICE_SINGLETON, ManagerRepository::class],
    ];

    /** @var array<array-key, string> */
    protected const QUERY_HANDLERS = [];

    /** @var array<array-key, string> */
    protected const COMMAND_HANDLERS = [
        \Project\Domains\Company\Manager\Application\Manager\Commands\Create\CommandHandler::class,
        \Project\Domains\Company\Manager\Application\Manager\Commands\Delete\CommandHandler::class,
    ];

    /** @var array<array-key, string> */
    protected const DOMAIN_EVENT_SUBSCRIBERS = [
        // Company
        \Project\Domains\Company\Manager\Application\Manager\Subscribers\Company\CompanyWasCreatedDomainEventSubscriber::class,
        \Project\Domains\Company\Manager\Application\Manager\Subscribers\Company\CompanyWasDeletedDomainEventSubscriber::class,
    ];

    /** @var array<string, string> */
    protected const ENTITY_TYPES = [
        \Project\Domains\Company\Manager\Infrastructure\Manager\Repositories\Doctrine\Types\UuidType::class,
        \Project\Domains\Company\Manager\Infrastructure\Manager\Repositories\Doctrine\Types\FirstNameType::class,
        \Project\Domains\Company\Manager\Infrastructure\Manager\Repositories\Doctrine\Types\LastNameType::class,
        \Project\Domains\Company\Manager\Infrastructure\Manager\Repositories\Doctrine\Types\EmailType::class,
        \Project\Domains\Company\Manager\Infrastructure\Manager\Repositories\Doctrine\Types\CompanyUuidType::class,
    ];

    /** @var array<array-key, string> */
    protected const MIGRATION_PATHS = [
        'Project\Domains\Company\Manager\Infrastructure\Manager\Repositories\Doctrine\Migrations' => __DIR__ . '/Manager/Repositories/Doctrine/Migrations',
    ];

    /** @var array<string, string> */
    protected const ENTITY_PATHS = [
        __DIR__ . '/../Domain/Manager',
    ];

    /** @var array<string, string> */
    protected const ROUTE_PATHS = [
        [
            'middleware' => ['api', 'auth:company'],
            'prefix' => 'api/admin',
            'path' => __DIR__ . '/../Presentation/Http/API/REST/routes.php',
        ],
    ];
}
