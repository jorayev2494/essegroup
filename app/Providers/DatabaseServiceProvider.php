<?php

namespace App\Providers;

use Doctrine\Common\Collections\ArrayCollection;
use Illuminate\Support\ServiceProvider;

class DatabaseServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        #region Doctrine
        // Entities
        $this->app->singleton('admin_doctrine_entity_paths', static fn (): ArrayCollection => new ArrayCollection());

        \Illuminate\Foundation\Application::macro('addAdminEntityPaths', function (array $entityPaths): void {
            $entityPathCollect = $this->make('admin_doctrine_entity_paths');

            foreach ($entityPaths as $entityPath) {
                $entityPathCollect->add($entityPath);
            }
        });

        $this->app->singleton('client_doctrine_entity_paths', static fn (): ArrayCollection => new ArrayCollection());

        \Illuminate\Foundation\Application::macro('addClientEntityPaths', function (array $entityPaths): void {
            $entityPathCollect = $this->make('client_doctrine_entity_paths');

            foreach ($entityPaths as $entityPath) {
                $entityPathCollect->add($entityPath);
            }
        });

        // Migrations
        $this->app->singleton('admin_doctrine_migration_paths', static fn (): array => []);

        \Illuminate\Foundation\Application::macro('addAdminMigrationPaths', function (array $migrationsPaths): void {
            $migrationPathCollection = $this->make('admin_doctrine_migration_paths');
            $this->singleton('admin_doctrine_migration_paths', static fn (): array => array_merge($migrationPathCollection, $migrationsPaths));
        });

        $this->app->singleton('client_doctrine_migration_paths', static fn (): array => []);

        \Illuminate\Foundation\Application::macro('addClientMigrationPaths', function (array $migrationsPaths): void {
            $migrationPathCollection = $this->make('client_doctrine_migration_paths');
            $this->singleton('client_doctrine_migration_paths', static fn (): array => array_merge($migrationPathCollection, $migrationsPaths));
        });
        #endregion
    }

    public function boot(): void
    {
        //
    }
}
