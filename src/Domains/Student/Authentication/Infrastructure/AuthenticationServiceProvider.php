<?php

namespace Project\Domains\Student\Authentication\Infrastructure;

use App\Providers\Domains\AdminDomainServiceProvider;
use Project\Domains\Student\Authentication\Domain\Code\CodeRepositoryInterface;
use Project\Domains\Student\Authentication\Domain\Device\DeviceRepositoryInterface;
use Project\Domains\Student\Authentication\Infrastructure\Repositories\Doctrine\Code\CodeRepository;
use Project\Domains\Student\Authentication\Infrastructure\Repositories\Doctrine\Device\DeviceRepository;

class AuthenticationServiceProvider extends AdminDomainServiceProvider
{
    /** @var array<string, string> */
    protected const SERVICES = [
        DeviceRepositoryInterface::class => [self::SERVICE_BIND, DeviceRepository::class],
        CodeRepositoryInterface::class => [self::SERVICE_BIND, CodeRepository::class],
    ];

    /** @var array<array-key, string> */
    protected const QUERY_HANDLERS = [];

    /** @var array<array-key, string> */
    protected const COMMAND_HANDLERS = [
        \Project\Domains\Student\Authentication\Application\Authentication\Commands\Login\CommandHandler::class,
        \Project\Domains\Student\Authentication\Application\Authentication\Commands\RefreshToken\CommandHandler::class,
        \Project\Domains\Student\Authentication\Application\Authentication\Commands\RestorePasswordLink\CommandHandler::class,
        \Project\Domains\Student\Authentication\Application\Authentication\Commands\RestorePassword\CommandHandler::class,
    ];

    /** @var array<array-key, string> */
    protected const DOMAIN_EVENT_SUBSCRIBERS = [
        // Company
        // \Project\Domains\Student\Authentication\Application\Student\Subscribers\CompanyWasCreatedDomainEventSubscriber::class,
        // \Project\Domains\Student\Authentication\Application\Student\Subscribers\CompanyWasDeletedDomainEventSubscriber::class,

        // Authentication
        // \Project\Domains\Student\Authentication\Application\Authentication\Subscribers\Manager\ManagerWasCreatedDomainEventSubscriber::class,
        // \Project\Domains\Student\Authentication\Application\Authentication\Subscribers\Manager\ManagerWasDeletedDomainEventSubscriber::class,
    ];

    /** @var array<string, string> */
    protected const ENTITY_TYPES = [];

    /** @var array<array-key, string> */
    protected const MIGRATION_PATHS = [

    ];

    /** @var array<string, string> */
    protected const ENTITY_PATHS = [
        __DIR__ . '/../Domain/Device',
        __DIR__ . '/../Domain/Code',
    ];

    /** @var array<string, string> */
    protected const ROUTE_PATHS = [
        [
            'middleware' => 'api',
            'prefix' => 'api/student',
            'path' => __DIR__ . '/../Presentation/Http/API/REST/routes.php',
        ],
    ];
}
