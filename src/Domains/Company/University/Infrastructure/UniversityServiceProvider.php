<?php

namespace Project\Domains\Company\University\Infrastructure;

use App\Providers\Domains\CompanyDomainServiceProvider;
use Project\Domains\Company\University\Domain\University\Services\Contracts\UniversityServiceInterface;
use Project\Domains\Company\University\Domain\University\Services\UniversityService;

class UniversityServiceProvider extends CompanyDomainServiceProvider
{
    /** @var array<string, string> */
    protected const SERVICES = [
        // Services
        UniversityServiceInterface::class => [self::SERVICE_SINGLETON, UniversityService::class],
        // MemberRepositoryInterface::class => [self::SERVICE_BIND, MemberRepository::class],
    ];

    /** @var array<array-key, string> */
    protected const QUERY_HANDLERS = [
        \Project\Domains\Company\University\Application\University\Queries\Index\QueryHandler::class,
    ];

    /** @var array<array-key, string> */
    protected const COMMAND_HANDLERS = [
        // \Project\Domains\Company\Authentication\Application\Authentication\Commands\Login\CommandHandler::class,
    ];

    /** @var array<array-key, string> */
    protected const DOMAIN_EVENT_SUBSCRIBERS = [
        // \Project\Domains\Company\Authentication\Application\Company\Subscribers\CompanyWasCreatedDomainEventSubscriber::class,
    ];

    /** @var array<string, string> */
    protected const ENTITY_TYPES = [
        // \Project\Domains\Company\Authentication\Infrastructure\Repositories\Doctrine\Member\Types\UuidType::class,
    ];

    /** @var array<array-key, string> */
    protected const MIGRATION_PATHS = [
        // 'Project\Domains\Company\Authentication\Infrastructure\Repositories\Doctrine\Migrations' => __DIR__ . '/Repositories/Doctrine/Migrations',
    ];

    /** @var array<string, string> */
    protected const ENTITY_PATHS = [
        __DIR__ . '/../Domain/University',
    ];

    /** @var array<string, string> */
    protected const ROUTE_PATHS = [
        [
            'middleware' => 'api',
            'prefix' => 'api/company',
            'path' => __DIR__ . '/../Presentation/Http/API/REST/routes.php',
        ],
    ];
}
