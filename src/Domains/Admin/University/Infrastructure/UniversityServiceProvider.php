<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Infrastructure;

use App\Providers\Domains\AdminDomainServiceProvider;
use Project\Domains\Admin\University\Domain\Company\CompanyRepositoryInterface;
use Project\Domains\Admin\University\Domain\Department\DepartmentRepositoryInterface;
use Project\Domains\Admin\University\Domain\Faculty\FacultyRepositoryInterface;
use Project\Domains\Admin\University\Domain\University\Services\Translation\Contracts\TranslationColumnServiceInterface;
use Project\Domains\Admin\University\Domain\University\Services\Translation\TranslationColumnService;
use Project\Domains\Admin\University\Domain\University\UniversityRepositoryInterface;
use Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\Company\CompanyRepository;
use Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\Department\DepartmentRepository;
use Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\Faculty\FacultyRepository;
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
        CompanyRepositoryInterface::class => [self::SERVICE_SINGLETON, CompanyRepository::class],
        DepartmentRepositoryInterface::class => [self::SERVICE_SINGLETON, DepartmentRepository::class],
        CoverServiceInterface::class => [self::SERVICE_SINGLETON, CoverService::class],
        LogoServiceInterface::class => [self::SERVICE_SINGLETON, LogoService::class],
        TranslationColumnServiceInterface::class => [self::SERVICE_SINGLETON, TranslationColumnService::class],
        FacultyRepositoryInterface::class => [self::SERVICE_SINGLETON, FacultyRepository::class],
        \Project\Domains\Admin\University\Domain\Faculty\Services\Logo\Contracts\LogoServiceInterface::class => [self::SERVICE_SINGLETON, \Project\Domains\Admin\University\Domain\Faculty\Services\Logo\LogoService::class],
        // \Project\Domains\Admin\University\Domain\Faculty\Services\Logo\Contracts\LogoServiceInterface::class => [self::SERVICE_SINGLETON, LogoService::class],
        \Project\Domains\Admin\University\Domain\Faculty\Services\Translation\Contracts\TranslationColumnServiceInterface::class => [self::SERVICE_SINGLETON, \Project\Domains\Admin\University\Domain\Faculty\Services\Translation\TranslationColumnService::class],
        \Project\Domains\Admin\University\Domain\Department\Services\Translation\Contracts\TranslationColumnServiceInterface::class => [self::SERVICE_SINGLETON, \Project\Domains\Admin\University\Domain\Department\Services\Translation\TranslationColumnService::class],

        // Application
        \Project\Domains\Admin\University\Domain\Application\ApplicationRepositoryInterface::class => [self::SERVICE_SINGLETON, \Project\Domains\Admin\University\Infrastructure\Application\Repositories\Doctrine\ApplicationRepository::class],
        \Project\Domains\Admin\University\Infrastructure\Application\Services\Files\BiometricPhoto\Contracts\BiometricPhotoServiceInterface::class => [self::SERVICE_SINGLETON, \Project\Domains\Admin\University\Infrastructure\Application\Services\Files\BiometricPhoto\BiometricPhotoService::class],
        \Project\Domains\Admin\University\Infrastructure\Application\Services\Files\Passport\Contracts\PassportServiceInterface::class => [self::SERVICE_SINGLETON, \Project\Domains\Admin\University\Infrastructure\Application\Services\Files\Passport\PassportService::class],
        \Project\Domains\Admin\University\Infrastructure\Application\Services\Files\PassportTranslation\Contracts\PassportTranslationServiceInterface::class => [self::SERVICE_SINGLETON, \Project\Domains\Admin\University\Infrastructure\Application\Services\Files\PassportTranslation\PassportTranslationService::class],
        \Project\Domains\Admin\University\Infrastructure\Application\Services\Files\Transcript\Contracts\TranscriptServiceInterface::class => [self::SERVICE_SINGLETON, \Project\Domains\Admin\University\Infrastructure\Application\Services\Files\Transcript\TranscriptService::class],
        \Project\Domains\Admin\University\Infrastructure\Application\Services\Files\TranscriptTranslation\Contracts\TranscriptTranslationServiceInterface::class => [self::SERVICE_SINGLETON, \Project\Domains\Admin\University\Infrastructure\Application\Services\Files\TranscriptTranslation\TranscriptTranslationService::class],
        \Project\Domains\Admin\University\Infrastructure\Application\Services\Files\SchoolAttestat\Contracts\SchoolAttestatServiceInterface::class => [self::SERVICE_SINGLETON, \Project\Domains\Admin\University\Infrastructure\Application\Services\Files\SchoolAttestat\SchoolAttestatService::class],
        \Project\Domains\Admin\University\Infrastructure\Application\Services\Files\SchoolAttestatTranslation\Contracts\SchoolAttestatTranslationServiceInterface::class => [self::SERVICE_SINGLETON, \Project\Domains\Admin\University\Infrastructure\Application\Services\Files\SchoolAttestatTranslation\SchoolAttestatTranslationService::class],
        \Project\Domains\Admin\University\Infrastructure\Application\Services\Files\EquivalenceDocument\Contracts\EquivalenceDocumentServiceInterface::class => [self::SERVICE_SINGLETON, \Project\Domains\Admin\University\Infrastructure\Application\Services\Files\EquivalenceDocument\EquivalenceDocumentService::class],
        \Project\Domains\Admin\University\Domain\Application\Services\Contracts\StatusServiceInterface::class => [self::SERVICE_SINGLETON, \Project\Domains\Admin\University\Domain\Application\Services\StatusService::class],
        \Project\Domains\Admin\University\Infrastructure\Application\Services\Files\AdditionalDocument\Contracts\AdditionalDocumentServiceInterface::class => [self::SERVICE_SINGLETON, \Project\Domains\Admin\University\Infrastructure\Application\Services\Files\AdditionalDocument\AdditionalDocumentService::class],

        // Country
        \Project\Domains\Admin\University\Domain\Country\CountryRepositoryInterface::class => [self::SERVICE_SINGLETON, \Project\Domains\Admin\University\Infrastructure\Country\Repositories\Doctrine\CountryRepository::class]
    ];

    /** @var array<array-key, string> */
    protected const QUERY_HANDLERS = [
        \Project\Domains\Admin\University\Application\University\Queries\Show\QueryHandler::class,
        \Project\Domains\Admin\University\Application\University\Queries\Index\QueryHandler::class,
        \Project\Domains\Admin\University\Application\University\Queries\List\QueryHandler::class,

        // Faculty
        \Project\Domains\Admin\University\Application\Faculty\Queries\Index\QueryHandler::class,
        \Project\Domains\Admin\University\Application\Faculty\Queries\Show\QueryHandler::class,
        \Project\Domains\Admin\University\Application\Faculty\Queries\List\QueryHandler::class,

        // Department
        \Project\Domains\Admin\University\Application\Department\Queries\Index\QueryHandler::class,
        \Project\Domains\Admin\University\Application\Department\Queries\Show\QueryHandler::class,
        \Project\Domains\Admin\University\Application\Department\Queries\List\QueryHandler::class,

        // Application
        \Project\Domains\Admin\University\Application\Application\Queries\Index\QueryHandler::class,
        \Project\Domains\Admin\University\Application\Application\Queries\Show\QueryHandler::class,
        \Project\Domains\Admin\University\Application\Application\Queries\StatusList\QueryHandler::class,

        // Country
        \Project\Domains\Admin\University\Application\Country\Queries\List\QueryHandler::class,
    ];

    /** @var array<string, string> */
    protected const ENTITY_TYPES = [
        // University
        \Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\University\Types\UuidType::class,
        \Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\University\Types\YouTubeVideoIdType::class,
        \Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\University\Types\NameType::class,
        \Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\University\Types\LabelType::class,
        \Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\University\Types\DescriptionType::class,

        // Company
        \Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\Company\Types\UuidType::class,
        \Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\Company\Types\NameType::class,
        \Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\Company\Types\DomainType::class,
        \Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\Company\Types\StatusType::class,

        // University
        \Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\Faculty\Types\UuidType::class,
        \Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\Faculty\Types\NameType::class,
        \Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\Faculty\Types\DescriptionType::class,

        // Department
        \Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\Department\Types\UuidType::class,
        \Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\Department\Types\NameType::class,
        \Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\Department\Types\DescriptionType::class,

        // Application
        \Project\Domains\Admin\University\Infrastructure\Application\Repositories\Doctrine\Types\UuidType::class,
        \Project\Domains\Admin\University\Infrastructure\Application\Repositories\Doctrine\Types\PassportNumberType::class,
        \Project\Domains\Admin\University\Infrastructure\Application\Repositories\Doctrine\Types\FatherNameType::class,
        \Project\Domains\Admin\University\Infrastructure\Application\Repositories\Doctrine\Types\MotherNameType::class,
        \Project\Domains\Admin\University\Infrastructure\Application\Repositories\Doctrine\Types\FriendPhoneType::class,
        \Project\Domains\Admin\University\Infrastructure\Application\Repositories\Doctrine\Types\FullNameType::class,
        \Project\Domains\Admin\University\Infrastructure\Application\Repositories\Doctrine\Types\EmailType::class,
        \Project\Domains\Admin\University\Infrastructure\Application\Repositories\Doctrine\Types\PhoneType::class,
        \Project\Domains\Admin\University\Infrastructure\Application\Repositories\Doctrine\Types\StatusEnumType::class,
        \Project\Domains\Admin\University\Infrastructure\Application\Repositories\Doctrine\Types\HomeAddressType::class,


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

        // Department
        \Project\Domains\Admin\University\Application\Department\Commands\Create\CommandHandler::class,
        \Project\Domains\Admin\University\Application\Department\Commands\Update\CommandHandler::class,
        \Project\Domains\Admin\University\Application\Department\Commands\Delete\CommandHandler::class,

        // Application
        \Project\Domains\Admin\University\Application\Application\Commands\Create\CommandHandler::class,
        \Project\Domains\Admin\University\Application\Application\Commands\Update\CommandHandler::class,
        \Project\Domains\Admin\University\Application\Application\Commands\Delete\CommandHandler::class,
    ];

    /** @var array<array-key, string> */
    protected const DOMAIN_EVENT_SUBSCRIBERS = [
        \Project\Domains\Admin\University\Application\Company\Subscribers\CompanyWasCreatedDomainEventSubscriber::class,

        \Project\Domains\Admin\University\Application\Country\Subscribers\CountryWasCreatedDomainEventSubscriber::class,
        \Project\Domains\Admin\University\Application\Country\Subscribers\CountryWasChangedValueDomainEventSubscriber::class,
        \Project\Domains\Admin\University\Application\Country\Subscribers\CountryWasChangedISODomainEventSubscriber::class,
        \Project\Domains\Admin\University\Application\Country\Subscribers\CountryWasChangedIsActiveDomainEventSubscriber::class,
    ];

    /** @var array<array-key, string> */
    protected const MIGRATION_PATHS = [
        // 'Project\Domains\Admin\Country\Infrastructure\Repositories\Doctrine\Migrations' => __DIR__ . '/Repositories/Doctrine/Migrations',
    ];

    /** @var array<string, string> */
    protected const ROUTE_PATHS = [
        [
            'middleware' => ['api', 'auth:admin'],
            'prefix' => 'api/admin',
            'path' => __DIR__ . '/../Presentation/Http/API/REST/routes.php',
        ],
    ];

    /** @var array<string, string> */
    protected const ENTITY_PATHS = [
        __DIR__ . '/../Domain/University',
        __DIR__ . '/../Domain/University/ValueObjects',
        __DIR__ . '/../Domain/Company',
        __DIR__ . '/../Domain/Faculty',
        __DIR__ . '/../Domain/Faculty/ValueObjects',
        __DIR__ . '/../Domain/Department',
        __DIR__ . '/../Domain/Application/ValueObjects',
        __DIR__ . '/../Domain/Application',
        __DIR__ . '/../Domain/Country',
    ];
}
