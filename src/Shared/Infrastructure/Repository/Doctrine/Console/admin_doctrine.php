<?php

declare(strict_types=1);

// require_once __DIR__ . '/../../../../../../bootstrap/app.php';
require_once __DIR__ . '/../../../../../../public/index.php';

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Console\EntityManagerProvider\SingleManagerProvider;

/** @var EntityManagerInterface $entityManager */
$entityManager = $app->make(\Project\Shared\Infrastructure\Repository\Contracts\BoundedContexts\AdminEntityManagerInterface::class);

//dd($entityManager);

ConsoleRunner::run(
    new SingleManagerProvider($entityManager)
);
