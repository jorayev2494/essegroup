<?php

namespace Project\Domains\Admin\Authentication\Infrastructure;

use App\Providers\Domains\AdminDomainServiceProvider;
use Project\Domains\Admin\Authentication\Domain\Code\CodeRepositoryInterface;
use Project\Domains\Admin\Authentication\Domain\Device\DeviceRepositoryInterface;
use Project\Domains\Admin\Authentication\Domain\Member\MemberRepositoryInterface;
use Project\Domains\Admin\Authentication\Infrastructure\Repositories\Doctrine\Code\CodeRepository;
use Project\Domains\Admin\Authentication\Infrastructure\Repositories\Doctrine\Device\DeviceRepository;
use Project\Domains\Admin\Authentication\Infrastructure\Repositories\Doctrine\Member\MemberRepository;

class AuthenticationServiceProvider extends AdminDomainServiceProvider
{
    /** @var array<string, string> */
    protected const SERVICES = [
        MemberRepositoryInterface::class => [self::SERVICE_BIND, MemberRepository::class],
        DeviceRepositoryInterface::class => [self::SERVICE_BIND, DeviceRepository::class],
        CodeRepositoryInterface::class => [self::SERVICE_BIND, CodeRepository::class],
    ];

    /** @var array<array-key, string> */
    protected const QUERY_HANDLERS = [];

    /** @var array<array-key, string> */
    protected const COMMAND_HANDLERS = [
        \Project\Domains\Admin\Authentication\Application\Authentication\Commands\Login\CommandHandler::class,
        \Project\Domains\Admin\Authentication\Application\Authentication\Commands\RefreshToken\CommandHandler::class,
        \Project\Domains\Admin\Authentication\Application\Authentication\Commands\RestorePasswordLink\CommandHandler::class,
        \Project\Domains\Admin\Authentication\Application\Authentication\Commands\RestorePassword\CommandHandler::class,
    ];

    /** @var array<array-key, string> */
    protected const DOMAIN_EVENT_SUBSCRIBERS = [
        // Restore
        \Project\Domains\Admin\Authentication\Application\Authentication\Subsribers\Restore\MemberRestorePasswordLinkWasAddedDomainEventSubscriber::class,
    ];

    /** @var array<string, string> */
    protected const ENTITY_TYPES = [
        \Project\Domains\Admin\Authentication\Infrastructure\Repositories\Doctrine\Member\Types\UuidType::class,
        \Project\Domains\Admin\Authentication\Infrastructure\Repositories\Doctrine\Member\Types\EmailType::class,
        \Project\Domains\Admin\Authentication\Infrastructure\Repositories\Doctrine\Member\Types\PasswordType::class,
    ];

    /** @var array<array-key, string> */
    protected const MIGRATION_PATHS = [
        'Project\Domains\Admin\Authentication\Infrastructure\Repositories\Doctrine\Migrations' => __DIR__ . '/Repositories/Doctrine/Migrations',
        // 'Project\Domains\Admin\Authentication\Infrastructure\Repositories\Doctrine\Migrations' => __DIR__ . '/Repositories/Doctrine/Migrations',
    ];

    /** @var array<string, string> */
    protected const ENTITY_PATHS = [
        __DIR__ . '/../Domain/Member',
        __DIR__ . '/../Domain/Device',
        __DIR__ . '/../Domain/Code',
    ];

    /** @var array<string, string> */
    protected const ROUTE_PATHS = [
        [
            'middleware' => 'api',
            'prefix' => 'api/admin',
            'path' => __DIR__ . '/../Presentation/Http/API/REST/routes.php',
        ],
    ];

    public function register(): void
    {
        $this->app->bind(MemberRepositoryInterface::class, MemberRepository::class);
    }
}
