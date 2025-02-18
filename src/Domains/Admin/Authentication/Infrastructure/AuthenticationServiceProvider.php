<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Infrastructure;

use App\Providers\Domains\AdminDomainServiceProvider;
use Project\Domains\Admin\Authentication\Domain\Code\CodeRepositoryInterface;
use Project\Domains\Admin\Authentication\Domain\Device\DeviceRepositoryInterface;
use Project\Domains\Admin\Authentication\Infrastructure\Repositories\Doctrine\Code\CodeRepository;
use Project\Domains\Admin\Authentication\Infrastructure\Repositories\Doctrine\Device\DeviceRepository;
use Project\Domains\Admin\Manager\Domain\Manager\ManagerRepositoryInterface;
use Project\Domains\Admin\Manager\Infrastructure\Manager\Repositories\Doctrine\ManagerRepository;

class AuthenticationServiceProvider extends AdminDomainServiceProvider
{
    /** @var array<string, string> */
    protected const SERVICES = [
        ManagerRepositoryInterface::class => [self::SERVICE_BIND, ManagerRepository::class],
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
    protected const DOMAIN_EVENT_SUBSCRIBERS = [];

    /** @var array<string, string> */
    protected const ENTITY_TYPES = [

    ];

    /** @var array<array-key, string> */
    protected const MIGRATION_PATHS = [
        'Project\Domains\Admin\Authentication\Infrastructure\Repositories\Doctrine\Migrations' => __DIR__ . '/Repositories/Doctrine/Migrations',
        // 'Project\Domains\Admin\Authentication\Infrastructure\Repositories\Doctrine\Migrations' => __DIR__ . '/Repositories/Doctrine/Migrations',
    ];

    /** @var array<string, string> */
    protected const ENTITY_PATHS = [
        // __DIR__ . '/../Domain/Member',
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
        $this->app->bind(ManagerRepositoryInterface::class, ManagerRepository::class);
    }
}
