<?php

namespace App\Providers;

use Doctrine\Common\EventManager;
use Doctrine\DBAL\DriverManager;
use Doctrine\Migrations\Version\Comparator;
use Gedmo\Mapping\Driver\AttributeReader;
use Gedmo\Translatable\TranslatableListener;
use Project\Shared\Infrastructure\Repository\Doctrine\EntityManager;
use Doctrine\ORM\ORMSetup;
use Illuminate\Support\ServiceProvider;
use Project\Shared\Infrastructure\Repository\Contracts\BoundedContexts\AdminEntityManagerInterface;
use Project\Shared\Infrastructure\Repository\Contracts\BoundedContexts\CompanyEntityManagerInterface;
use Project\Shared\Infrastructure\Repository\Contracts\BoundedContexts\ClientEntityManagerInterface;
use Project\Shared\Infrastructure\Repository\Doctrine\MigrationEventSubscriber;
use Project\Shared\Infrastructure\Repository\Doctrine\ProjectVersionComparator;
use Symfony\Component\Cache\Adapter\ArrayAdapter;

class DoctrineServiceProvider extends ServiceProvider
{
    private EventManager $eventManager;

    private array $adminConnection = [];

    private array $companyConnection = [];

    private array $clientConnection = [];

    public function register(): void
    {
        $this->adminConnection = [
            'dbname' => env('ADMIN_DB_DATABASE'),
            'user' => env('ADMIN_DB_USERNAME'),
            'password' => env('ADMIN_DB_PASSWORD'),
            'host' => env('ADMIN_DB_HOST'),
            'driver' => 'pdo_mysql',
        ];

        $this->companyConnection = [
            'dbname' => env('COMPANY_DB_DATABASE'),
            'user' => env('COMPANY_DB_USERNAME'),
            'password' => env('COMPANY_DB_PASSWORD'),
            'host' => env('COMPANY_DB_HOST'),
            'driver' => 'pdo_mysql',
        ];

        $this->clientConnection = [
            'dbname' => env('CLIENT_DB_DATABASE'),
            'user' => env('CLIENT_DB_USERNAME'),
            'password' => env('CLIENT_DB_PASSWORD'),
            'host' => env('CLIENT_DB_HOST'),
            'driver' => 'pdo_mysql',
        ];

        $this->connectAdminEntityManager();
        $this->connectCompanyEntityManager();
        $this->connectClientEntityManager();
    }

    public function boot(): void
    {
//        $this->app->singleton(Comparator::class, ProjectVersionComparator::class);
    }

    private function connectAdminEntityManager(): void
    {
        $config = ORMSetup::createAttributeMetadataConfiguration(
            paths: $this->app->make('admin_doctrine_entity_paths')->toArray(),
            isDevMode: !$this->app->environment('production'),
        );

        $connection = DriverManager::getConnection($this->adminConnection, $config, $this->getEventManager());
        $entityManager = new EntityManager($connection, $config);

        $this->app->instance(AdminEntityManagerInterface::class, $entityManager);
        $this->app->instance('admin_dbal_connection', $connection);
    }

    private function connectCompanyEntityManager(): void
    {
        $config = ORMSetup::createAttributeMetadataConfiguration(
            paths: $this->app->make('company_doctrine_entity_paths')->toArray(),
            isDevMode: !$this->app->environment('production'),
        );

        $connection = DriverManager::getConnection($this->companyConnection, $config, $this->getEventManager());
        $entityManager = new EntityManager($connection, $config);

        $this->app->instance(CompanyEntityManagerInterface::class, $entityManager);
        $this->app->instance('company_dbal_connection', $connection);
    }

    private function connectClientEntityManager(): void
    {
        $config = ORMSetup::createAttributeMetadataConfiguration(
            paths: $res = $this->app->make('client_doctrine_entity_paths')->toArray(),
            isDevMode: !$this->app->environment('production'),
        );

        $connection = DriverManager::getConnection($this->clientConnection, $config, $this->getEventManager());
        $entityManager = new EntityManager($connection, $config);

        $this->app->instance(ClientEntityManagerInterface::class, $entityManager);
        $this->app->instance('client_dbal_connection', $connection);
    }

    private function getEventManager(): EventManager
    {
        $eventManager = new EventManager();

        // TranslatableListener
//        $cache = new ArrayAdapter();
//        $translatableListener = new TranslatableListener();
//        $translatableListener->setTranslatableLocale('en'); // en_us
//        $translatableListener->setDefaultLocale('en');  // en_us
//        $translatableListener->setAnnotationReader(new AttributeReader());
//        $translatableListener->setCacheItemPool($cache);
//        $eventManager->addEventSubscriber($translatableListener);

        //
        $migrationEventSubscriber = new MigrationEventSubscriber();
        $eventManager->addEventSubscriber($migrationEventSubscriber);

        return $eventManager;
    }
}
