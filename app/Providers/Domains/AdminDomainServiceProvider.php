<?php

declare(strict_types=1);

namespace App\Providers\Domains;

class AdminDomainServiceProvider extends DomainServiceProvider
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
        $this->app->addAdminMigrationPaths(static::MIGRATION_PATHS);
    }

    protected function registerEntityPaths(): void
    {
        $this->app->addAdminEntityPaths(static::ENTITY_PATHS);
    }

    protected function registerConfigs(): void
    {
        $this->registerConfigsByPrefix('admin');
    }

    protected function registerNotifications(): void
    {
        $this->app->addNotifications(static::NOTIFICATIONS);
    }
}
