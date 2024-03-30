<?php

namespace Project\Domains\Company\Authentication\Infrastructure;

use App\Providers\Domains\CompanyDomainServiceProvider;
use Project\Domains\Company\Authentication\Domain\Code\CodeRepositoryInterface;
use Project\Domains\Company\Authentication\Domain\Company\CompanyRepositoryInterface;
use Project\Domains\Company\Authentication\Domain\Device\DeviceRepositoryInterface;
use Project\Domains\Company\Authentication\Domain\Member\MemberRepositoryInterface;
use Project\Domains\Company\Authentication\Infrastructure\Company\Repositories\Doctrine\CompanyRepository;
use Project\Domains\Company\Authentication\Infrastructure\Repositories\Doctrine\Code\CodeRepository;
use Project\Domains\Company\Authentication\Infrastructure\Repositories\Doctrine\Device\DeviceRepository;
use Project\Domains\Company\Authentication\Infrastructure\Repositories\Doctrine\Member\MemberRepository;

class AuthenticationServiceProvider extends CompanyDomainServiceProvider
{
    /** @var array<string, string> */
    protected const SERVICES = [
        MemberRepositoryInterface::class => [self::SERVICE_BIND, MemberRepository::class],
        DeviceRepositoryInterface::class => [self::SERVICE_BIND, DeviceRepository::class],
        CodeRepositoryInterface::class => [self::SERVICE_BIND, CodeRepository::class],
        CompanyRepositoryInterface::class => [self::SERVICE_BIND, CompanyRepository::class],
    ];

    /** @var array<array-key, string> */
    protected const QUERY_HANDLERS = [];

    /** @var array<array-key, string> */
    protected const COMMAND_HANDLERS = [
        \Project\Domains\Company\Authentication\Application\Authentication\Commands\Create\CommandHandler::class,
        \Project\Domains\Company\Authentication\Application\Authentication\Commands\Delete\CommandHandler::class,
        \Project\Domains\Company\Authentication\Application\Authentication\Commands\Login\CommandHandler::class,
        \Project\Domains\Company\Authentication\Application\Authentication\Commands\RefreshToken\CommandHandler::class,
        \Project\Domains\Company\Authentication\Application\Authentication\Commands\RestorePasswordLink\CommandHandler::class,
        \Project\Domains\Company\Authentication\Application\Authentication\Commands\RestorePassword\CommandHandler::class,
    ];

    /** @var array<array-key, string> */
    protected const DOMAIN_EVENT_SUBSCRIBERS = [
        // Company
        // \Project\Domains\Company\Authentication\Application\Company\Subscribers\CompanyWasCreatedDomainEventSubscriber::class,
        // \Project\Domains\Company\Authentication\Application\Company\Subscribers\CompanyWasDeletedDomainEventSubscriber::class,

        // Authentication
        // \Project\Domains\Company\Authentication\Application\Authentication\Subscribers\Manager\ManagerWasCreatedDomainEventSubscriber::class,
        // \Project\Domains\Company\Authentication\Application\Authentication\Subscribers\Manager\ManagerWasDeletedDomainEventSubscriber::class,
    ];

    /** @var array<string, string> */
    protected const ENTITY_TYPES = [
        \Project\Domains\Company\Authentication\Infrastructure\Repositories\Doctrine\Member\Types\UuidType::class,
        \Project\Domains\Company\Authentication\Infrastructure\Repositories\Doctrine\Member\Types\EmailType::class,
        \Project\Domains\Company\Authentication\Infrastructure\Repositories\Doctrine\Member\Types\PasswordType::class,
    ];

    /** @var array<array-key, string> */
    protected const MIGRATION_PATHS = [
        'Project\Domains\Company\Authentication\Infrastructure\Repositories\Doctrine\Migrations' => __DIR__ . '/Repositories/Doctrine/Migrations',
        // 'Project\Domains\Admin\Authentication\Infrastructure\Repositories\Doctrine\Migrations' => __DIR__ . '/Repositories/Doctrine/Migrations',
    ];

    /** @var array<string, string> */
    protected const ENTITY_PATHS = [
        __DIR__ . '/../Domain/Member',
        __DIR__ . '/../Domain/Device',
        __DIR__ . '/../Domain/Code',
        __DIR__ . '/../Domain/Company',
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
