<?php

declare(strict_types=1);

namespace App\Providers\Domains;

class ClientDomainServiceProvider extends DomainServiceProvider
{
    public function register(): void
    {
        parent::register();
    }

    public function boot(): void
    {
        parent::boot();
    }

    protected function registerMigrationPaths(): void
    {
        $this->app->addClientMigrationPaths(static::MIGRATION_PATHS);
    }

    protected function registerEntityPaths(): void
    {
        $this->app->addClientEntityPaths(static::ENTITY_PATHS);
    }

    protected function registerConfigs(): void
    {
        $this->registerConfigsByPrefix('client');
    }

    protected function registerNotifications(): void
    {
        $this->app->addNotifications(static::NOTIFICATIONS);
    }
}
