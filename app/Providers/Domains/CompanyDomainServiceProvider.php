<?php

declare(strict_types=1);

namespace App\Providers\Domains;

class CompanyDomainServiceProvider extends DomainServiceProvider
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
        $this->app->addCompanyMigrationPaths(static::MIGRATION_PATHS);
    }

    protected function registerEntityPaths(): void
    {
        $this->app->addCompanyEntityPaths(static::ENTITY_PATHS);
    }
}
