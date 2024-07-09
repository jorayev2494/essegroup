<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Infrastructure;

use App\Providers\Domains\AdminDomainServiceProvider;
use Project\Domains\Admin\University\Domain\Degree\DegreeRepositoryInterface;
use Project\Domains\Admin\University\Domain\University\UniversityRepositoryInterface;
use Project\Domains\Admin\University\Infrastructure\Degree\Repositories\Doctrine\DegreeRepository;
use Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\University\UniversityRepository;
use Project\Domains\Admin\University\Infrastructure\Services\Media\Cover\Contracts\CoverServiceInterface;
use Project\Domains\Admin\University\Infrastructure\Services\Media\Cover\CoverService;
use Project\Domains\Admin\University\Infrastructure\Services\Media\Logo\Contracts\LogoServiceInterface;
use Project\Domains\Admin\University\Infrastructure\Services\Media\Logo\LogoService;

class UniversityServiceProvider extends AdminDomainServiceProvider
{
    /** @var array<string, string> */
    protected const SERVICES = [
        UniversityRepositoryInterface::class => [self::SERVICE_SINGLETON, UniversityRepository::class],
        CoverServiceInterface::class => [self::SERVICE_SINGLETON, CoverService::class],
        LogoServiceInterface::class => [self::SERVICE_SINGLETON, LogoService::class],
        DegreeRepositoryInterface::class => [self::SERVICE_SINGLETON, DegreeRepository::class],

        // Faculty
        \Project\Domains\Admin\University\Domain\Faculty\FacultyRepositoryInterface::class => [self::SERVICE_SINGLETON, \Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\Faculty\FacultyRepository::class],
        // Name Faculty
        \Project\Domains\Admin\University\Domain\Faculty\Name\FacultyNameRepositoryInterface::class => [self::SERVICE_SINGLETON, \Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\Faculty\Name\FacultyNameRepository::class],

        // Department
        \Project\Domains\Admin\University\Domain\Department\DepartmentRepositoryInterface::class => [self::SERVICE_SINGLETON, \Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\Department\DepartmentRepository::class],
        // Department Name
        \Project\Domains\Admin\University\Domain\Department\Name\DepartmentNameRepositoryInterface::class => [self::SERVICE_SINGLETON, \Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\Department\Name\DepartmentNameRepository::class],

        \Project\Domains\Admin\University\Domain\Faculty\Services\Logo\Contracts\LogoServiceInterface::class => [self::SERVICE_SINGLETON, \Project\Domains\Admin\University\Domain\Faculty\Services\Logo\LogoService::class],
        // \Project\Domains\Admin\University\Domain\Faculty\Services\Logo\Contracts\LogoServiceInterface::class => [self::SERVICE_SINGLETON, LogoService::class],

        // Application
        \Project\Domains\Admin\University\Domain\Application\ApplicationRepositoryInterface::class => [self::SERVICE_SINGLETON, \Project\Domains\Admin\University\Infrastructure\Application\Repositories\Doctrine\ApplicationRepository::class],
        \Project\Domains\Admin\University\Domain\Application\Services\Contracts\StatusServiceInterface::class => [self::SERVICE_SINGLETON, \Project\Domains\Admin\University\Domain\Application\Services\StatusService::class],
        \Project\Domains\Admin\University\Domain\Application\Services\Contracts\ApplicationServiceInterface::class => [self::SERVICE_SINGLETON, \Project\Domains\Admin\University\Domain\Application\Services\ApplicationService::class],
        \Project\Domains\Admin\University\Domain\Alias\AliasRepositoryInterface::class => [self::SERVICE_SINGLETON, \Project\Domains\Admin\University\Infrastructure\Alias\Repositories\Doctrine\AliasRepository::class],

        \Project\Domains\Admin\University\Domain\Application\StatusValueRepositoryInterface::class => [self::SERVICE_SINGLETON, \Project\Domains\Admin\University\Infrastructure\Application\Repositories\Doctrine\StatusValueRepository::class],
    ];

    /** @var array<array-key, string> */
    protected const QUERY_HANDLERS = [
        // University
        \Project\Domains\Admin\University\Application\University\Queries\Show\QueryHandler::class,
        \Project\Domains\Admin\University\Application\University\Queries\Index\QueryHandler::class,
        \Project\Domains\Admin\University\Application\University\Queries\List\QueryHandler::class,
        \Project\Domains\Admin\University\Application\University\Queries\Search\QueryHandler::class,

        // Faculty
        \Project\Domains\Admin\University\Application\Faculty\Queries\Index\QueryHandler::class,
        \Project\Domains\Admin\University\Application\Faculty\Queries\Show\QueryHandler::class,
        \Project\Domains\Admin\University\Application\Faculty\Queries\List\QueryHandler::class,

        // Faculty name
        \Project\Domains\Admin\University\Application\Faculty\Name\Queries\Index\QueryHandler::class,
        \Project\Domains\Admin\University\Application\Faculty\Name\Queries\List\QueryHandler::class,
        \Project\Domains\Admin\University\Application\Faculty\Name\Queries\Show\QueryHandler::class,

        // Department
        \Project\Domains\Admin\University\Application\Department\Queries\Index\QueryHandler::class,
        \Project\Domains\Admin\University\Application\Department\Queries\Show\QueryHandler::class,
        \Project\Domains\Admin\University\Application\Department\Queries\List\QueryHandler::class,

        // Department Name
        \Project\Domains\Admin\University\Application\DepartmentName\Queries\Index\QueryHandler::class,
        \Project\Domains\Admin\University\Application\DepartmentName\Queries\List\QueryHandler::class,
        \Project\Domains\Admin\University\Application\DepartmentName\Queries\Show\QueryHandler::class,

        // Application
        \Project\Domains\Admin\University\Application\Application\Queries\Index\QueryHandler::class,
        \Project\Domains\Admin\University\Application\Application\Queries\ByStudentUuid\QueryHandler::class,
        \Project\Domains\Admin\University\Application\Application\Queries\Show\QueryHandler::class,

        // Application Status Value
        \Project\Domains\Admin\University\Application\ApplicationStatusValue\Queries\Index\QueryHandler::class,
        \Project\Domains\Admin\University\Application\ApplicationStatusValue\Queries\Show\QueryHandler::class,
        \Project\Domains\Admin\University\Application\ApplicationStatusValue\Queries\List\QueryHandler::class,
        \Project\Domains\Admin\University\Application\ApplicationStatusValue\Queries\WidgetList\QueryHandler::class,

        // Degree
        \Project\Domains\Admin\University\Application\Degree\Queries\Index\QueryHandler::class,
        \Project\Domains\Admin\University\Application\Degree\Queries\List\QueryHandler::class,
        \Project\Domains\Admin\University\Application\Degree\Queries\Show\QueryHandler::class,

        // Alias
        \Project\Domains\Admin\University\Application\Alias\Queries\Index\QueryHandler::class,
        \Project\Domains\Admin\University\Application\Alias\Queries\List\QueryHandler::class,
        \Project\Domains\Admin\University\Application\Alias\Queries\Show\QueryHandler::class,
    ];

    /** @var array<string, string> */
    protected const ENTITY_TYPES = [
        // University
        \Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\University\Types\UuidType::class,
        \Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\University\Types\YouTubeVideoIdType::class,
        \Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\University\Types\NameType::class,
        \Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\University\Types\LabelType::class,
        \Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\University\Types\DescriptionType::class,

        // Faculty
        \Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\Faculty\Types\UuidType::class,
        \Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\Faculty\Types\DescriptionType::class,

        // Faculty Name
        \Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\Faculty\Name\Types\UuidType::class,
        \Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\Faculty\Name\Types\ValueType::class,

        // Department
        \Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\Department\Types\UuidType::class,
        \Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\Department\Types\PriceType::class,
        \Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\Department\Types\DiscountPriceType::class,
        \Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\Department\Types\DescriptionType::class,

        // Department Name
        \Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\Department\Name\Types\UuidType::class,
        \Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\Department\Name\Types\ValueType::class,
        \Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\Department\Name\Types\DescriptionType::class,

        // Application
        \Project\Domains\Admin\University\Infrastructure\Application\Repositories\Doctrine\Types\UuidType::class,
        \Project\Domains\Admin\University\Infrastructure\Application\Repositories\Doctrine\Types\StatusEnumType::class,
        \Project\Domains\Admin\University\Infrastructure\Application\Repositories\Doctrine\Types\StatusIdType::class,
        \Project\Domains\Admin\University\Infrastructure\Application\Repositories\Doctrine\Types\StatusValueUuidType::class,
        \Project\Domains\Admin\University\Infrastructure\Application\Repositories\Doctrine\Types\StatusValueTextColorType::class,
        \Project\Domains\Admin\University\Infrastructure\Application\Repositories\Doctrine\Types\StatusValueBackgroundColorType::class,
        \Project\Domains\Admin\University\Infrastructure\Application\Repositories\Doctrine\Types\StatusValueDescriptionType::class,
        \Project\Domains\Admin\University\Infrastructure\Application\Repositories\Doctrine\Types\StatusValueValueType::class,

        // Degree
        \Project\Domains\Admin\University\Infrastructure\Degree\Repositories\Doctrine\Types\UuidType::class,
        \Project\Domains\Admin\University\Infrastructure\Degree\Repositories\Doctrine\Types\ValueType::class,

        // Alias
        \Project\Domains\Admin\University\Infrastructure\Alias\Repositories\Doctrine\Types\UuidType::class,
        \Project\Domains\Admin\University\Infrastructure\Alias\Repositories\Doctrine\Types\ValueType::class,
    ];

    /** @var array<array-key, string> */
    protected const COMMAND_HANDLERS = [
        \Project\Domains\Admin\University\Application\University\Commands\Create\CommandHandler::class,
        \Project\Domains\Admin\University\Application\University\Commands\Update\CommandHandler::class,
        \Project\Domains\Admin\University\Application\University\Commands\Delete\CommandHandler::class,

        // Faculty
        \Project\Domains\Admin\University\Application\Faculty\Commands\Create\CommandHandler::class,
        \Project\Domains\Admin\University\Application\Faculty\Commands\Update\CommandHandler::class,
        \Project\Domains\Admin\University\Application\Faculty\Commands\Delete\CommandHandler::class,

        // Faculty Name
        \Project\Domains\Admin\University\Application\Faculty\Name\Commands\Create\CommandHandler::class,
        \Project\Domains\Admin\University\Application\Faculty\Name\Commands\Update\CommandHandler::class,
        \Project\Domains\Admin\University\Application\Faculty\Name\Commands\Delete\CommandHandler::class,

        // Department
        \Project\Domains\Admin\University\Application\Department\Commands\Create\CommandHandler::class,
        \Project\Domains\Admin\University\Application\Department\Commands\Update\CommandHandler::class,
        \Project\Domains\Admin\University\Application\Department\Commands\Delete\CommandHandler::class,

        // Department Name
        \Project\Domains\Admin\University\Application\DepartmentName\Commands\Create\CommandHandler::class,
        \Project\Domains\Admin\University\Application\DepartmentName\Commands\Update\CommandHandler::class,
        \Project\Domains\Admin\University\Application\DepartmentName\Commands\Delete\CommandHandler::class,

        // Application
        \Project\Domains\Admin\University\Application\Application\Commands\Create\CommandHandler::class,
        \Project\Domains\Admin\University\Application\Application\Commands\Update\CommandHandler::class,
        \Project\Domains\Admin\University\Application\Application\Commands\Delete\CommandHandler::class,

        // Application Status Item
        \Project\Domains\Admin\University\Application\ApplicationStatusValue\Commands\Create\CommandHandler::class,
        \Project\Domains\Admin\University\Application\ApplicationStatusValue\Commands\Update\CommandHandler::class,
        \Project\Domains\Admin\University\Application\ApplicationStatusValue\Commands\Delete\CommandHandler::class,

        // Degree
        \Project\Domains\Admin\University\Application\Degree\Commands\Create\CommandHandler::class,
        \Project\Domains\Admin\University\Application\Degree\Commands\Update\CommandHandler::class,
        \Project\Domains\Admin\University\Application\Degree\Commands\Delete\CommandHandler::class,

        // Alias
        \Project\Domains\Admin\University\Application\Alias\Commands\Create\CommandHandler::class,
        \Project\Domains\Admin\University\Application\Alias\Commands\Update\CommandHandler::class,
        \Project\Domains\Admin\University\Application\Alias\Commands\Delete\CommandHandler::class,
    ];

    /** @var array<array-key, string> */
    protected const MIGRATION_PATHS = [
        // 'Project\Domains\Admin\Country\Infrastructure\Repositories\Doctrine\Migrations' => __DIR__ . '/Repositories/Doctrine/Migrations',
    ];

    /** @var array<array-key, string> */
    protected const DOMAIN_EVENT_SUBSCRIBERS = [
        // Application

        // Application Status
        \Project\Domains\Admin\University\Application\Application\Subscribers\Application\ApplicationStatusWasChangedDomainEventSubscriber::class,

        // Department

        // Faculty

        // University

        // Degree

        // Company
    ];

    /** @var array<string, string> */
    protected const ENTITY_PATHS = [
        __DIR__ . '/../Domain/University',
        __DIR__ . '/../Domain/University/ValueObjects',
        __DIR__ . '/../Domain/Faculty',
        __DIR__ . '/../Domain/Faculty/Name',
        __DIR__ . '/../Domain/Faculty/ValueObjects',
        __DIR__ . '/../Domain/Department',
        __DIR__ . '/../Domain/Department/Name',
        __DIR__ . '/../Domain/Application/ValueObjects',
        __DIR__ . '/../Domain/Application',
        __DIR__ . '/../Domain/Degree',
        __DIR__ . '/../Domain/Alias',
    ];

    /** @var array<string, string> */
    protected const ROUTE_PATHS = [
        [
            'middleware' => ['api', 'auth:admin'],
            'prefix' => 'api/admin',
            'path' => __DIR__ . '/../Presentation/Http/API/REST/routes.php',
        ],
    ];
}
