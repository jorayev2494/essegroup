<?php

declare(strict_types=1);

namespace App\Providers\Domains;

use App\Providers\Contracts\AppServiceProviderInterface;
use Doctrine\DBAL\Types\Type;
use Illuminate\Support\ServiceProvider;

abstract class DomainServiceProvider extends ServiceProvider implements AppServiceProviderInterface
{
    /** @var array<string, string> */
    protected const SERVICES = [
        // CurrencyRepositoryInterface::class => [self::SERVICE_BIND, CurrencyRepository::class],
    ];

    /** @var array<array-key, string> */
    protected const QUERY_HANDLERS = [];

    /** @var array<array-key, string> */
    protected const COMMAND_HANDLERS = [];

    /** @var array<array-key, string> */
    protected const DOMAIN_EVENT_SUBSCRIBERS = [];

    /** @var array<string, string> */
    protected const ENTITY_TYPES = [
        // \Project\Domains\Admin\Currency\Infrastructure\Repositories\Doctrine\Currency\Types\UuidType::class,
    ];

    /** @var array<array-key, string> */
    protected const MIGRATION_PATHS = [
        // 'Project\Domains\Admin\Country\Infrastructure\Repositories\Doctrine\Migrations' => __DIR__ . '/Repositories/Doctrine/Migrations',
    ];

    /** @var array<string, string> */
    protected const ENTITY_PATHS = [
        // __DIR__ . '/../Domain',
    ];

    /** @var array<string, string> */
    protected const ROUTE_PATHS = [
        // [
        //     'middleware' => 'api',
        //     'prefix' => 'api/admin',
        //     'path' => __DIR__ . '/../Presentation/Http/API/REST/routes.php',
        // ],

        // [
        //     'middleware' => 'web',
        //     'prefix' => 'admin',
        //     'path' => __DIR__ . '/../Presentation/Http/Web/REST/routes.php',
        // ],
    ];

    public function register(): void
    {

    }

    public function boot(): void
    {
        $this->registerMigrationPaths();
        $this->registerEntityPaths();
        $this->registerEntityTypes();

        $this->registerServices();
        $this->registerQueryHandlers();
        $this->registerCommandHandlers();
        $this->registerDomainEventSubscribers();
        $this->registerRoutes();
    }

    abstract protected function registerMigrationPaths(): void;

    abstract protected function registerEntityPaths(): void;

    private function registerRoutes(): void
    {
        foreach (static::ROUTE_PATHS as ['middleware' => $middleware, 'prefix' => $prefix, 'path' => $path]) {
            $this->app->make('route.registrar')
                ->middleware($middleware)
                ->prefix($prefix)
                ->group($path);
        }
    }

    private function registerEntityTypes(): void
    {
        foreach (static::ENTITY_TYPES as $typeClassName) {
            Type::addType($typeClassName::NAME, $typeClassName);
        }
    }

    private function registerServices(): void
    {
        foreach (static::SERVICES as $abstractClassName => $data) {
            [$registerType, $service] = $data;
            // dd($registerType, $abstractClassName, $service);
            $this->app->$registerType($abstractClassName, $service);
        }
    }

    private function registerQueryHandlers(): void
    {
        foreach (static::QUERY_HANDLERS as $className) {
            $this->app->tag($className, 'query_handler');
        }
    }

    private function registerCommandHandlers(): void
    {
        foreach (static::COMMAND_HANDLERS as $className) {
            $this->app->tag($className, 'command_handler');
        }
    }

    private function registerDomainEventSubscribers(): void
    {
        foreach (static::DOMAIN_EVENT_SUBSCRIBERS as $className) {
            $this->app->tag($className, 'domain_event_subscriber');
        }
    }
}
