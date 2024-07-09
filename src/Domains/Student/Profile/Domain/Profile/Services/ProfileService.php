<?php

declare(strict_types=1);

namespace Project\Domains\Student\Profile\Domain\Profile\Services;

use Project\Domains\Admin\Student\Application\Commands\Update\Command as UpdateCommand;
use Project\Domains\Student\Profile\Application\Profile\Commands\Update\Command;
use Project\Domains\Student\Profile\Domain\Profile\Services\Contracts\ProfileServiceInterface;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Project\Shared\Domain\ValueObject\UuidValueObject;

class ProfileService implements ProfileServiceInterface
{
    public function update(UuidValueObject $uuid, Command $command): void
    {
        /** @var CommandBusInterface $commandBus */
        $commandBus = resolve(CommandBusInterface::class);

        $commandBus->dispatch(
            new UpdateCommand(
                $uuid->value,
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
                $command->companyUuid,
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
}
