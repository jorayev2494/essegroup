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
use Project\Shared\Infrastructure\Repository\Contracts\BoundedContexts\ClientEntityManagerInterface;
use Project\Shared\Infrastructure\Repository\Doctrine\ProjectVersionComparator;
use Symfony\Component\Cache\Adapter\ArrayAdapter;

class DoctrineServiceProvider extends ServiceProvider
{
    private array $adminConnection = [
        'dbname' => 'admindatabase',
        'user' => 'essegroupuser',
        'password' => 'essegrouppassword',
        'host' => 'postgres',
        'driver' => 'pdo_pgsql',
    ];

    private array $clientConnection = [
        'dbname' => 'clientdatabase',
        'user' => 'essegroupuser',
        'password' => 'essegrouppassword',
        'host' => 'postgres',
        'driver' => 'pdo_pgsql',
    ];

    public function register(): void
    {
        $this->connectAdminEntityManager();
        $this->connectClientEntityManager();
    }

    public function boot(): void
    {
        $this->app->singleton(Comparator::class, ProjectVersionComparator::class);
    }

    private function connectAdminEntityManager(): void
    {
        $config = ORMSetup::createAttributeMetadataConfiguration(
            paths: $this->app->make('admin_doctrine_entity_paths')->toArray(),
            isDevMode: !$this->app->environment('production'),
        );

        $this->adminConnection['host'] = env('ADMIN_DB_HOST');
        $connection = DriverManager::getConnection($this->adminConnection, $config);
        $entityManager = new EntityManager($connection, $config);

        $this->app->instance(AdminEntityManagerInterface::class, $entityManager);
        $this->app->instance('admin_dbal_connection', $connection);
        // dd(__METHOD__, $this->app->make(AdminEntityManagerInterface::class));
    }

    private function connectClientEntityManager(): void
    {
        $config = ORMSetup::createAttributeMetadataConfiguration(
            paths: $res = $this->app->make('client_doctrine_entity_paths')->toArray(),
            isDevMode: !$this->app->environment('production'),
        );

        $this->clientConnection['host'] = env('CLIENT_DB_HOST');
        $connection = DriverManager::getConnection($this->clientConnection, $config);
        $entityManager = new EntityManager($connection, $config);

        $this->app->instance(ClientEntityManagerInterface::class, $entityManager);
        $this->app->instance('client_dbal_connection', $connection);
    }

    private function getEventManager(): EventManager
    {
        $eventManager = new EventManager();
        $cache = new ArrayAdapter();
        $translatableListener = new TranslatableListener();
        $translatableListener->setTranslatableLocale('en'); // en_us
        $translatableListener->setDefaultLocale('en');  // en_us
        $translatableListener->setAnnotationReader(new AttributeReader());
        $translatableListener->setCacheItemPool($cache);
        $eventManager->addEventSubscriber($translatableListener);

        return $eventManager;
    }
}
