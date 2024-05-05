<?php

declare(strict_types=1);

namespace Project\Domains\Public\Student\Domian\Student\Services;

use Project\Domains\Public\Student\Application\Commands\Create\Command;
use Project\Domains\Public\Student\Domian\Student\Services\Contracts\StudentServiceInterface;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Project\Domains\Admin\Student\Application\Commands\Create\Command as CreateCommand;

readonly class StudentService implements StudentServiceInterface
{
    public function create(Command $command): void
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
                $command->creatorRole,
                $command->passport,
                $command->passportTranslation,
                $command->schoolAttestat,
                $command->schoolAttestatTranslation,
                $command->transcript,
                $command->transcriptTranslation,
                $command->equivalenceDocument,
                $command->biometricPhoto,
                $command->additionalDocuments,
                $command->companyUuid,
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
}
