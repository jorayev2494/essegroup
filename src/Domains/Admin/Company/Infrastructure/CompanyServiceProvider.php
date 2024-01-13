<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Company\Infrastructure;

use App\Providers\Domains\AdminDomainServiceProvider;
use Project\Domains\Admin\Company\Domain\Company\CompanyRepositoryInterface;
use Project\Domains\Admin\Company\Infrastructure\Repositories\Doctrine\Company\CompanyRepository;

class CompanyServiceProvider extends AdminDomainServiceProvider
{
    /** @var array<string, string> */
    protected const SERVICES = [
        CompanyRepositoryInterface::class => [self::SERVICE_BIND, CompanyRepository::class],
    ];

    /** @var array<array-key, string> */
    protected const QUERY_HANDLERS = [
        \Project\Domains\Admin\Company\Application\Company\Queries\Index\QueryHandler::class,
        \Project\Domains\Admin\Company\Application\Company\Queries\Show\QueryHandler::class,
    ];

    /** @var array<array-key, string> */
    protected const COMMAND_HANDLERS = [
        \Project\Domains\Admin\Company\Application\Company\Commands\Create\CommandHandler::class,
        \Project\Domains\Admin\Company\Application\Company\Commands\Update\CommandHandler::class,
        \Project\Domains\Admin\Company\Application\Company\Commands\Delete\CommandHandler::class,
    ];

    /** @var array<array-key, string> */
    protected const DOMAIN_EVENT_SUBSCRIBERS = [
        \Project\Domains\Admin\Company\Application\Company\Subscribers\CompanyWasCreatedDomainEventSubscriber::class,
    ];

    /** @var array<string, string> */
    protected const ENTITY_TYPES = [
        // Company
        \Project\Domains\Admin\Company\Infrastructure\Repositories\Doctrine\Company\Types\UuidType::class,
        \Project\Domains\Admin\Company\Infrastructure\Repositories\Doctrine\Company\Types\NameType::class,
        \Project\Domains\Admin\Company\Infrastructure\Repositories\Doctrine\Company\Types\DomainType::class,

        // Status
        \Project\Domains\Admin\Company\Infrastructure\Repositories\Doctrine\Status\Types\ValueType::class,
        \Project\Domains\Admin\Company\Infrastructure\Repositories\Doctrine\Status\Types\NoteType::class,
    ];

    /** @var array<array-key, string> */
    protected const MIGRATION_PATHS = [
        'Project\Domains\Admin\Country\Infrastructure\Repositories\Doctrine\Migrations' => __DIR__ . '/Repositories/Doctrine/Migrations',
    ];

    /** @var array<string, string> */
    protected const ENTITY_PATHS = [
         __DIR__ . '/../Domain/Company',
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
