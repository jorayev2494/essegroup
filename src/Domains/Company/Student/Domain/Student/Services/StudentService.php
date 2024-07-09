<?php

declare(strict_types=1);

namespace Project\Domains\Company\Student\Domain\Student\Services;

use Project\Domains\Company\Student\Application\Student\Commands\Create\Command as CreateStudentCommand;
use Project\Domains\Company\Student\Application\Student\Commands\Update\Command as UpdateStudentCommand;
use Project\Domains\Company\Student\Application\Student\Queries\Index\Query;
use Project\Domains\Company\Student\Domain\Student\Services\Contracts\StudentServiceInterface;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;
use Project\Domains\Admin\Student\Application\Queries\Index\Query as IndexQuery;
use Project\Domains\Admin\Student\Application\Commands\Create\Command as CreateCommand;
use Project\Domains\Admin\Student\Application\Queries\Show\Query as ShowQuery;
use Project\Domains\Admin\Student\Application\Commands\Update\Command as UpdateCommand;
use Project\Domains\Admin\Student\Application\Commands\Delete\Command as DeleteCommand;
use Project\Shared\Domain\ValueObject\UuidValueObject;

class StudentService implements StudentServiceInterface
{
    public function index(UuidValueObject $companyUuid, Query $query): array
    {
        /** @var QueryBusInterface $queryBus */
        $queryBus = resolve(QueryBusInterface::class);

        return $queryBus->ask(
            IndexQuery::makeFromArray(
                array_merge(
                    $query->toArray(),
                    [
                        'company_uuids' => [$companyUuid->value],
                    ]
                )
            )
        );
    }

    public function create(UuidValueObject $companyUuid, CreateStudentCommand $command): void
    {
        /** @var CommandBusInterface $commandBus */
        $commandBus = resolve(CommandBusInterface::class);

        $commandBus->dispatch(
            new CreateCommand(
                $command->uuid,
                $command->firstName,
                $command->lastName,
                $command->avatar,
                $command->birthday,
                $command->passportNumber,
                $command->email,
                $command->phone,
                $command->nationalityUuid,
                $command->countryOfResidenceUuid,
                $command->highSchoolCountryUuid,
                'company',
                $command->passport,
                $command->passportTranslation,
                $command->schoolAttestat,
                $command->schoolAttestatTranslation,
                $command->transcript,
                $command->transcriptTranslation,
                $command->equivalenceDocument,
                $command->biometricPhoto,
                $command->additionalDocuments,
                $companyUuid->value,
                $command->communicationLanguageUuid,
                $command->fatherName,
                $command->motherName,
                $command->friendPhone,
                $command->homeAddress,
                $command->gender,
                $command->maritalType,
                $command->passportDateOfIssue,
                $command->passportDateOfExpiry,
                $command->highSchoolName,
                $command->highSchoolGradeAverage
            )
        );
    }

    public function show(UuidValueObject $companyUuid, UuidValueObject $uuid): array
    {
        /** @var QueryBusInterface $queryBus */
        $queryBus = resolve(QueryBusInterface::class);

        return $queryBus->ask(
            new ShowQuery($uuid->value)
        );
    }

    public function update(UuidValueObject $companyUuid, UpdateStudentCommand $command): void
    {
        /** @var CommandBusInterface $commandBus */
        $commandBus = resolve(CommandBusInterface::class);

        $commandBus->dispatch(
            new UpdateCommand(
                $command->uuid,
                $command->firstName,
                $command->lastName,
                $command->birthday,
                $command->passportNumber,
                $command->passportDateOfIssue,
                $command->passportDateOfExpiry,
                $command->email,
                $command->phone,
                $command->nationalityUuid,
                $command->countryOfResidenceUuid,
                $command->highSchoolName,
                $command->highSchoolCountryUuid,
                $command->highSchoolGradeAverage,
                $command->passport,
                $command->passportTranslation,
                $command->schoolAttestat,
                $command->schoolAttestatTranslation,
                $command->transcript,
                $command->transcriptTranslation,
                $command->equivalenceDocument,
                $command->biometricPhoto,
                $command->additionalDocuments,
                $command->avatar,
                $companyUuid->value,
                $command->communicationLanguageUuid,
                $command->fatherName,
                $command->motherName,
                $command->friendPhone,
                $command->homeAddress,
                $command->gender,
                $command->maritalType
            )
        );
    }

    public function delete(UuidValueObject $companyUuid, UuidValueObject $uuid): void
    {
        /** @var CommandBusInterface $commandBus */
        $commandBus = resolve(CommandBusInterface::class);

        $commandBus->dispatch(
            new DeleteCommand($uuid->value)
        );
    }
}
