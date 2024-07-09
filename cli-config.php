<?php

require_once __DIR__ . '/public/index.php';

use Doctrine\ORM\Mapping\Driver\AttributeDriver;
use Project\Shared\Infrastructure\Repository\Contracts\BoundedContexts\AdminEntityManagerInterface;
use Project\Shared\Infrastructure\Repository\Contracts\BoundedContexts\CompanyEntityManagerInterface;
use Project\Shared\Infrastructure\Repository\Contracts\BoundedContexts\ClientEntityManagerInterface;
use Doctrine\Migrations\Configuration\EntityManager\ExistingEntityManager;
use Doctrine\Migrations\Configuration\Migration\ConfigurationArray;
use Doctrine\Migrations\DependencyFactory;
use Doctrine\ORM\EntityManagerInterface;

$dbalKey = null;
$migrationsPaths = [];

$entity = getenv('ENTITY');

if (in_array($entity, ['admin', 'company', 'client'])) {
//    if ($entity === 'client')
//    {
//        /** @var EntityManagerInterface $entityManager */
//        $entityManager = $app->make(ClientEntityManagerInterface::class);
//        $migrationsPaths = $app->make('client_doctrine_migration_paths');
//        $entityManager->getConfiguration()
//            ->setMetadataDriverImpl(
//                new AttributeDriver($app->make('client_doctrine_entity_paths')->toArray())
//            );
//
//        $dbalKey = 'client_dbal_connection';
//    }
//    else if ($entity === 'company')
//    {
//        /** @var EntityManagerInterface $entityManager */
//        $entityManager = $app->make(CompanyEntityManagerInterface::class);
//        $migrationsPaths = $app->make('company_doctrine_migration_paths');
//        $entityManager->getConfiguration()
//            ->setMetadataDriverImpl(
//                new AttributeDriver($app->make('company_doctrine_entity_paths')->toArray())
//            );
//
//        $dbalKey = 'company_dbal_connection';
//    }
//    else
    if ($entity === 'admin')
    {
        /** @var EntityManagerInterface $entityManager */
        $entityManager = $app->make(AdminEntityManagerInterface::class);
        $migrationsPaths = $app->make('admin_doctrine_migration_paths');
        $entityManager->getConfiguration()
            ->setMetadataDriverImpl(
                new AttributeDriver($app->make('admin_doctrine_entity_paths')->toArray())
            );

        $dbalKey = 'admin_dbal_connection';
    }

    $conf = [
        'table_storage' => [
            'table_name' => 'doctrine_migration_versions',
            'version_column_name' => 'version',
            'version_column_length' => 191,
            'executed_at_column_name' => 'executed_at',
            'execution_time_column_name' => 'execution_time',
        ],

        // 'migrations_paths' => [
        //     // 'Project\Domains\Admin\Country\Infrastructure\Doctrine\Migrations' => '/var/project/src/Domains/Admin/Country/Infrastructure/Doctrine/Migrations',
        // ],

        'migrations_paths' => [...$migrationsPaths],

        'all_or_nothing' => true,
        'transactional' => true,
        'check_database_platform' => true,
        'organize_migrations' => 'none',
        'connection' => null,
        'em' => null,
    ];

    $config = new ConfigurationArray($conf);

    /** @var \Doctrine\DBAL\Connection $dbalConnection */
    $dbalConnection = $app->make($dbalKey);

    $di = DependencyFactory::fromEntityManager($config, new ExistingEntityManager($entityManager));

    // $di->setService(\Doctrine\Migrations\Version\Comparator::class, new \Project\Shared\Infrastructure\Repository\Doctrine\ProjectVersionComparator());

    return $di;
}
