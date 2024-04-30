<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Announcement\Infrastructure;

use App\Providers\Domains\AdminDomainServiceProvider;
use Project\Domains\Admin\Announcement\Domain\Announcement\AnnouncementRepositoryInterface;
use Project\Domains\Admin\Announcement\Infrastructure\Announcement\Repositories\Doctrine\AnnouncementRepository;

class AnnouncementServiceProvider extends AdminDomainServiceProvider
{
    /** @var array<string, string> */
    protected const SERVICES = [
        AnnouncementRepositoryInterface::class => [self::SERVICE_SINGLETON, AnnouncementRepository::class],
    ];

    /** @var array<array-key, string> */
    protected const QUERY_HANDLERS = [
        \Project\Domains\Admin\Announcement\Application\Announcement\Queries\Index\QueryHandler::class,
        \Project\Domains\Admin\Announcement\Application\Announcement\Queries\List\QueryHandler::class,
        \Project\Domains\Admin\Announcement\Application\Announcement\Queries\Show\QueryHandler::class,
        \Project\Domains\Admin\Announcement\Application\Announcement\Queries\View\QueryHandler::class,
    ];

    /** @var array<array-key, string> */
    protected const COMMAND_HANDLERS = [
        \Project\Domains\Admin\Announcement\Application\Announcement\Commands\Create\CommandHandler::class,
        \Project\Domains\Admin\Announcement\Application\Announcement\Commands\Update\CommandHandler::class,
        \Project\Domains\Admin\Announcement\Application\Announcement\Commands\Delete\CommandHandler::class,
    ];

    /** @var array<array-key, string> */
    protected const DOMAIN_EVENT_SUBSCRIBERS = [];

    /** @var array<string, string> */
    protected const ENTITY_TYPES = [
        Announcement\Repositories\Doctrine\Types\UuidType::class,
        Announcement\Repositories\Doctrine\Types\ForType::class,
        Announcement\Repositories\Doctrine\Types\TitleType::class,
        Announcement\Repositories\Doctrine\Types\ContentType::class,
    ];

    /** @var array<array-key, string> */
    protected const MIGRATION_PATHS = [
        // 'Project\Domains\Admin\Country\Infrastructure\Repositories\Doctrine\Migrations' => __DIR__ . '/Repositories/Doctrine/Migrations',
    ];

    /** @var array<string, string> */
    protected const ENTITY_PATHS = [
        __DIR__ . '/../Domain/Announcement',
    ];

    /** @var array<string, string> */
    protected const ROUTE_PATHS = [
        [
            'middleware' => ['api', 'auth:admin'],
            'prefix' => 'api/admin/announcements',
            'path' => __DIR__ . '/../Presentation/Http/API/REST/routes.php',
        ],
    ];
}
