<?php

declare(strict_types=1);

namespace Project\Domains\Public\University\Infrastructure;

use App\Providers\Domains\AdminDomainServiceProvider;
use Project\Domains\Admin\Country\Domain\Country\CountryRepositoryInterface;
use Project\Domains\Admin\Country\Infrastructure\Country\Repositories\Doctrine\CountryRepository;
use Project\Domains\Public\University\Domain\Alias\Services\AliasService;
use Project\Domains\Public\University\Domain\Alias\Services\Contracts\AliasServiceInterface;
use Project\Domains\Public\University\Domain\Application\Services\ApplicationService;
use Project\Domains\Public\University\Domain\Application\Services\Contracts\ApplicationServiceInterface;
use Project\Domains\Public\University\Domain\City\Services\CityService;
use Project\Domains\Public\University\Domain\City\Services\Contracts\CityServiceInterface;
use Project\Domains\Public\University\Domain\Country\Services\Contracts\CountryServiceInterface;
use Project\Domains\Public\University\Domain\Country\Services\CountryService;
use Project\Domains\Public\University\Domain\Degree\Services\Contracts\DegreeServiceInterface;
use Project\Domains\Public\University\Domain\Degree\Services\DegreeService;
use Project\Domains\Public\University\Domain\Department\Services\Contracts\DepartmentServiceInterface;
use Project\Domains\Public\University\Domain\Department\Services\DepartmentService;
use Project\Domains\Public\University\Domain\DepartmentName\Services\Contracts\DepartmentNameServiceInterface;
use Project\Domains\Public\University\Domain\DepartmentName\Services\DepartmentNameService;
use Project\Domains\Public\University\Domain\Faculty\Services\Contracts\FacultyServiceInterface;
use Project\Domains\Public\University\Domain\Faculty\Services\FacultyService;
use Project\Domains\Public\University\Domain\FacultyName\Services\Contracts\FacultyNameServiceInterface;
use Project\Domains\Public\University\Domain\FacultyName\Services\FacultyNameService;
use Project\Domains\Public\University\Domain\University\Services\Contracts\UniversityServiceInterface;
use Project\Domains\Public\University\Domain\University\Services\UniversityService;
use Project\Domains\Public\University\Domain\University\UniversityRepositoryInterface;
use Project\Domains\Public\University\Infrastructure\Repositories\Doctrine\University\UniversityRepository;

class UniversityServiceProvider extends AdminDomainServiceProvider
{
    /** @var array<string, string> */
    protected const SERVICES = [
        UniversityServiceInterface::class => [self::SERVICE_BIND, UniversityService::class],
        UniversityRepositoryInterface::class => [self::SERVICE_SINGLETON, UniversityRepository::class],
        ApplicationServiceInterface::class => [self::SERVICE_SINGLETON, ApplicationService::class],
        FacultyServiceInterface::class => [self::SERVICE_SINGLETON, FacultyService::class],
        CountryRepositoryInterface::class => [self::SERVICE_SINGLETON, CountryRepository::class],
        DepartmentServiceInterface::class => [self::SERVICE_SINGLETON, DepartmentService::class],
        CountryServiceInterface::class => [self::SERVICE_SINGLETON, CountryService::class],
        CityServiceInterface::class => [self::SERVICE_SINGLETON, CityService::class],
        DegreeServiceInterface::class => [self::SERVICE_SINGLETON, DegreeService::class],
        AliasServiceInterface::class => [self::SERVICE_SINGLETON, AliasService::class],
        FacultyNameServiceInterface::class => [self::SERVICE_SINGLETON, FacultyNameService::class],
        DepartmentNameServiceInterface::class => [self::SERVICE_SINGLETON, DepartmentNameService::class],
    ];

    /** @var array<array-key, string> */
    protected const QUERY_HANDLERS = [
        // University
        \Project\Domains\Public\University\Application\University\Queries\Index\QueryHandler::class,
        \Project\Domains\Public\University\Application\University\Queries\Show\QueryHandler::class,
        \Project\Domains\Public\University\Application\University\Queries\Search\QueryHandler::class,

        // City
        \Project\Domains\Public\University\Application\City\Queries\List\QueryHandler::class,

        // Degree
        \Project\Domains\Public\University\Application\Degree\Queries\List\QueryHandler::class,

        // Alias
        \Project\Domains\Public\University\Application\Alias\Queries\List\QueryHandler::class,

        // Faculty Name
        \Project\Domains\Public\University\Application\FacultyName\Queries\List\QueryHandler::class,

        // Department
        \Project\Domains\Public\University\Application\Department\Queries\Index\QueryHandler::class,
        \Project\Domains\Public\University\Application\Department\Queries\List\QueryHandler::class,

        // Department Name
        \Project\Domains\Public\University\Application\DepartmentName\Queries\List\QueryHandler::class,
        \Project\Domains\Public\University\Application\DepartmentName\Queries\Show\QueryHandler::class,
    ];

    /** @var array<array-key, string> */
    protected const COMMAND_HANDLERS = [
        // Application
        \Project\Domains\Public\University\Application\Application\Commands\Create\CommandHandler::class,
    ];

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
            'middleware' => 'api',
            'prefix' => 'api/public/universities',
            'path' => __DIR__ . '/../Presentation/Http/API/REST/routes.php',
        ],
    ];
}
