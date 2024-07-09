<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Document\Infrastructure;

use App\Providers\Domains\AdminDomainServiceProvider;
use Project\Domains\Admin\Document\Domain\Document\DocumentRepositoryInterface;
use Project\Domains\Admin\Document\Domain\Document\Services\File\Contracts\FileServiceInterface;
use Project\Domains\Admin\Document\Domain\Document\Services\File\FileService;
use Project\Domains\Admin\Document\Infrastructure\Document\Repositories\Doctrine\DocumentRepository;

class DocumentServiceProvider extends AdminDomainServiceProvider
{
    /** @var array<string, string> */
    protected const SERVICES = [
        DocumentRepositoryInterface::class => [self::SERVICE_SINGLETON, DocumentRepository::class],
        FileServiceInterface::class => [self::SERVICE_SINGLETON, FileService::class],
    ];

    /** @var array<array-key, string> */
    protected const QUERY_HANDLERS = [
        \Project\Domains\Admin\Document\Application\Document\Queries\Index\QueryHandler::class,
        \Project\Domains\Admin\Document\Application\Document\Queries\List\QueryHandler::class,
        \Project\Domains\Admin\Document\Application\Document\Queries\Show\QueryHandler::class,
        \Project\Domains\Admin\Document\Application\Document\Queries\Download\QueryHandler::class,
    ];

    /** @var array<array-key, string> */
    protected const COMMAND_HANDLERS = [
        // Document
        \Project\Domains\Admin\Document\Application\Document\Commands\Create\CommandHandler::class,
        \Project\Domains\Admin\Document\Application\Document\Commands\Update\CommandHandler::class,
        \Project\Domains\Admin\Document\Application\Document\Commands\Delete\CommandHandler::class,
    ];

    /** @var array<array-key, string> */
    protected const DOMAIN_EVENT_SUBSCRIBERS = [];

    /** @var array<string, string> */
    protected const ENTITY_TYPES = [
        \Project\Domains\Admin\Document\Infrastructure\Document\Repositories\Doctrine\Types\UuidType::class,
        \Project\Domains\Admin\Document\Infrastructure\Document\Repositories\Doctrine\Types\TitleType::class,
        \Project\Domains\Admin\Document\Infrastructure\Document\Repositories\Doctrine\Types\TypeType::class,
    ];

    /** @var array<array-key, string> */
    protected const MIGRATION_PATHS = [
        // 'Project\Domains\Admin\Country\Infrastructure\Repositories\Doctrine\Migrations' => __DIR__ . '/Repositories/Doctrine/Migrations',
    ];

    /** @var array<string, string> */
    protected const ENTITY_PATHS = [
        __DIR__ . '/../Domain/Document',
        __DIR__ . '/../Domain/Document/ValueObjects',
    ];

    /** @var array<string, string> */
    protected const ROUTE_PATHS = [
        [
            'middleware' => ['api', 'auth:admin'],
            'prefix' => 'api/admin/documents',
            'path' => __DIR__ . '/../Presentation/Http/API/REST/routes.php',
        ],
    ];
}
