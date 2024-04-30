<?php

declare(strict_types=1);

namespace Project\Domains\Company\Announcement\Infrastructure;

use App\Providers\Domains\AdminDomainServiceProvider;
use Project\Domains\Company\Announcement\Domain\Announcement\Services\AnnouncementService;
use Project\Domains\Company\Announcement\Domain\Announcement\Services\Contracts\AnnouncementServiceInterface;

class AnnouncementServiceProvider extends AdminDomainServiceProvider
{
    /** @var array<string, string> */
    protected const SERVICES = [
        AnnouncementServiceInterface::class => [self::SERVICE_SINGLETON, AnnouncementService::class],
    ];

    /** @var array<array-key, string> */
    protected const QUERY_HANDLERS = [
        \Project\Domains\Company\Announcement\Application\Announcement\Queries\Index\QueryHandler::class,
        \Project\Domains\Company\Announcement\Application\Announcement\Queries\List\QueryHandler::class,
        \Project\Domains\Company\Announcement\Application\Announcement\Queries\View\QueryHandler::class,
    ];

    /** @var array<array-key, string> */
    protected const COMMAND_HANDLERS = [];

    /** @var array<array-key, string> */
    protected const DOMAIN_EVENT_SUBSCRIBERS = [];

    /** @var array<string, string> */
    protected const ENTITY_TYPES = [
        // \Project\Domains\Admin\Currency\Infrastructure\Repositories\Doctrine\Currency\Types\UuidType::class,
    ];

    /** @var array<array-key, string> */
    protected const MIGRATION_PATHS = [
        // 'Project\Domains\Admin\Country\Infrastructure\Repositories\Doctrine\Migrations' => __DIR__ . '/Repositories/Doctrine/Migrations',
    ];

    /** @var array<string, string> */
    protected const ENTITY_PATHS = [
        // __DIR__ . '/../Domain',
    ];

    /** @var array<string, string> */
    protected const ROUTE_PATHS = [
        [
            'middleware' => ['api', 'auth:company'],
            'prefix' => 'api/company/announcements',
            'path' => __DIR__ . '/../Presentation/Http/API/REST/routes.php',
        ],
    ];
}
