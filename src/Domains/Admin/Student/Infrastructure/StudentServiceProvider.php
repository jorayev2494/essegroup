<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Student\Infrastructure;

use App\Providers\Domains\AdminDomainServiceProvider;

class StudentServiceProvider extends AdminDomainServiceProvider
{
    /** @var array<string, string> */
    protected const SERVICES = [
        // Student Repositories
        \Project\Domains\Admin\Student\Domain\Student\StudentRepositoryInterface::class => [self::SERVICE_SINGLETON, \Project\Domains\Admin\Student\Infrastructure\Student\Repositories\Doctrine\StudentRepository::class],

        // Student Services
        \Project\Domains\Admin\Student\Domain\Student\Services\Contracts\StudentServiceInterface::class => [self::SERVICE_SINGLETON, \Project\Domains\Admin\Student\Domain\Student\Services\StudentService::class],
        \Project\Domains\Admin\Student\Domain\Student\Services\Avatar\Contracts\AvatarServiceInterface::class => [self::SERVICE_SINGLETON, \Project\Domains\Admin\Student\Domain\Student\Services\Avatar\AvatarService::class],
        \Project\Domains\Admin\Student\Infrastructure\Student\Services\Files\BiometricPhoto\Contracts\BiometricPhotoServiceInterface::class => [self::SERVICE_SINGLETON, \Project\Domains\Admin\Student\Infrastructure\Student\Services\Files\BiometricPhoto\BiometricPhotoService::class],
        \Project\Domains\Admin\Student\Infrastructure\Student\Services\Files\Passport\Contracts\PassportServiceInterface::class => [self::SERVICE_SINGLETON, \Project\Domains\Admin\Student\Infrastructure\Student\Services\Files\Passport\PassportService::class],
        \Project\Domains\Admin\Student\Infrastructure\Student\Services\Files\PassportTranslation\Contracts\PassportTranslationServiceInterface::class => [self::SERVICE_SINGLETON, \Project\Domains\Admin\Student\Infrastructure\Student\Services\Files\PassportTranslation\PassportTranslationService::class],
        \Project\Domains\Admin\Student\Infrastructure\Student\Services\Files\Transcript\Contracts\TranscriptServiceInterface::class => [self::SERVICE_SINGLETON, \Project\Domains\Admin\Student\Infrastructure\Student\Services\Files\Transcript\TranscriptService::class],
        \Project\Domains\Admin\Student\Infrastructure\Student\Services\Files\TranscriptTranslation\Contracts\TranscriptTranslationServiceInterface::class => [self::SERVICE_SINGLETON, \Project\Domains\Admin\Student\Infrastructure\Student\Services\Files\TranscriptTranslation\TranscriptTranslationService::class],
        \Project\Domains\Admin\Student\Infrastructure\Student\Services\Files\SchoolAttestat\Contracts\SchoolAttestatServiceInterface::class => [self::SERVICE_SINGLETON, \Project\Domains\Admin\Student\Infrastructure\Student\Services\Files\SchoolAttestat\SchoolAttestatService::class],
        \Project\Domains\Admin\Student\Infrastructure\Student\Services\Files\SchoolAttestatTranslation\Contracts\SchoolAttestatTranslationServiceInterface::class => [self::SERVICE_SINGLETON, \Project\Domains\Admin\Student\Infrastructure\Student\Services\Files\SchoolAttestatTranslation\SchoolAttestatTranslationService::class],
        \Project\Domains\Admin\Student\Infrastructure\Student\Services\Files\EquivalenceDocument\Contracts\EquivalenceDocumentServiceInterface::class => [self::SERVICE_SINGLETON, \Project\Domains\Admin\Student\Infrastructure\Student\Services\Files\EquivalenceDocument\EquivalenceDocumentService::class],
        \Project\Domains\Admin\Student\Infrastructure\Student\Services\Files\AdditionalDocument\Contracts\AdditionalDocumentServiceInterface::class => [self::SERVICE_SINGLETON, \Project\Domains\Admin\Student\Infrastructure\Student\Services\Files\AdditionalDocument\AdditionalDocumentService::class],
    ];

    /** @var array<array-key, string> */
    protected const QUERY_HANDLERS = [
        // Student
        \Project\Domains\Admin\Student\Application\Queries\Index\QueryHandler::class,
        \Project\Domains\Admin\Student\Application\Queries\Show\QueryHandler::class,
    ];

    /** @var array<array-key, string> */
    protected const COMMAND_HANDLERS = [
        // Student
        \Project\Domains\Admin\Student\Application\Commands\Create\CommandHandler::class,
        \Project\Domains\Admin\Student\Application\Commands\Update\CommandHandler::class,
        \Project\Domains\Admin\Student\Application\Commands\Delete\CommandHandler::class,
    ];

    /** @var array<array-key, string> */
    protected const DOMAIN_EVENT_SUBSCRIBERS = [
        \Project\Domains\Admin\Student\Application\Subscribers\StudentWasCreatedDomainEventSubscriber::class,
        \Project\Domains\Admin\Student\Application\Subscribers\Auth\RestorePassword\StudentRestorePasswordLinkWasAddedDomainEventSubscriber::class,
    ];

    /** @var array<string, string> */
    protected const ENTITY_TYPES = [
        // Student
        \Project\Domains\Admin\Student\Infrastructure\Student\Repositories\Doctrine\Types\UuidType::class,
        \Project\Domains\Admin\Student\Infrastructure\Student\Repositories\Doctrine\Types\IdentityType::class,
        \Project\Domains\Admin\Student\Infrastructure\Student\Repositories\Doctrine\Types\PassportNumberType::class,
        \Project\Domains\Admin\Student\Infrastructure\Student\Repositories\Doctrine\Types\FatherNameType::class,
        \Project\Domains\Admin\Student\Infrastructure\Student\Repositories\Doctrine\Types\MotherNameType::class,
        \Project\Domains\Admin\Student\Infrastructure\Student\Repositories\Doctrine\Types\FriendPhoneType::class,
        \Project\Domains\Admin\Student\Infrastructure\Student\Repositories\Doctrine\Types\FirstNameType::class,
        \Project\Domains\Admin\Student\Infrastructure\Student\Repositories\Doctrine\Types\LastNameType::class,
        \Project\Domains\Admin\Student\Infrastructure\Student\Repositories\Doctrine\Types\EmailType::class,
        \Project\Domains\Admin\Student\Infrastructure\Student\Repositories\Doctrine\Types\PhoneType::class,
        \Project\Domains\Admin\Student\Infrastructure\Student\Repositories\Doctrine\Types\PasswordType::class,
        \Project\Domains\Admin\Student\Infrastructure\Student\Repositories\Doctrine\Types\HomeAddressType::class,
        \Project\Domains\Admin\Student\Infrastructure\Student\Repositories\Doctrine\Types\GenderType::class,
        \Project\Domains\Admin\Student\Infrastructure\Student\Repositories\Doctrine\Types\MaritalTypeType::class,
        \Project\Domains\Admin\Student\Infrastructure\Student\Repositories\Doctrine\Types\GradeAverageType::class,
        \Project\Domains\Admin\Student\Infrastructure\Student\Repositories\Doctrine\Types\HighSchoolNameType::class,
    ];

    /** @var array<array-key, string> */
    protected const MIGRATION_PATHS = [
        // 'Project\Domains\Admin\Country\Infrastructure\Repositories\Doctrine\Migrations' => __DIR__ . '/Repositories/Doctrine/Migrations',
    ];

    /** @var array<string, string> */
    protected const ENTITY_PATHS = [
        __DIR__ . '/../Domain/Student',
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
