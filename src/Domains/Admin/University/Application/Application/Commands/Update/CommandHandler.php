<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\Application\Commands\Update;

use Project\Domains\Admin\Company\Domain\Company\CompanyRepositoryInterface;
use Project\Domains\Admin\University\Domain\Application\ApplicationRepositoryInterface;
use Project\Domains\Admin\University\Domain\Application\Exceptions\ApplicationNotFoundDomainException;
use Project\Domains\Admin\University\Domain\Application\Services\Contracts\ApplicationServiceInterface;
use Project\Domains\Admin\University\Domain\Application\Services\Contracts\StatusServiceInterface;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\Email;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\FatherName;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\FriendPhone;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\FullName;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\HomeAddress;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\MotherName;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\PassportNumber;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\Phone;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\Status;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\Uuid;
use Project\Domains\Admin\Country\Domain\Country\CountryRepositoryInterface;
use Project\Domains\Admin\University\Domain\Faculty\FacultyRepositoryInterface;
use Project\Domains\Admin\University\Domain\University\UniversityRepositoryInterface;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Domains\Admin\University\Domain\University\ValueObjects\Uuid as UniversityUuid;
use Project\Domains\Admin\University\Domain\Faculty\ValueObjects\Uuid as FacultyUuid;
use Project\Domains\Admin\Country\Domain\Country\ValueObjects\Uuid as CountryUuid;
use Project\Domains\Admin\Company\Domain\Company\ValueObjects\Uuid as CompanyUuid;
use DateTimeImmutable;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private ApplicationRepositoryInterface $applicationRepository,
        private CompanyRepositoryInterface $companyRepository,
        private StatusServiceInterface $statusService,
        private UniversityRepositoryInterface $universityRepository,
        private CountryRepositoryInterface $countryRepository,
        private ApplicationServiceInterface $service
    )
    {

    }

    public function __invoke(Command $command): void
    {
        $application = $this->applicationRepository->findByUuid(Uuid::fromValue($command->uuid));
        $company = $this->companyRepository->findByUuid(CompanyUuid::fromValue($command->companyUuid));

        $application ?? throw new ApplicationNotFoundDomainException();

        $university = $this->universityRepository->findByUuid(UniversityUuid::fromValue($command->universityUuid));
        $country = $this->countryRepository->findByUuid(CountryUuid::fromValue($command->countryUuid));

        $application->changeCompany($company);
        $application->changeUniversity($university);
        $application->changeBirthday(new DateTimeImmutable($command->birthday));
        $application->changeCountry($country);
        $application->changeFullName(FullName::fromValue($command->fullName));
        $application->changePassportNumber(PassportNumber::fromValue($command->passportNumber));
        $application->changeEmail(Email::fromValue($command->email));
        $application->changePhone(Phone::fromValue($command->phone));
        $application->changeFatherName(FatherName::fromValue($command->fatherName));
        $application->changeMotherName(MotherName::fromValue($command->motherName));
        $application->changeFriendPhone(FriendPhone::fromValue($command->friendPhone));
        $application->changeHomeAddress(HomeAddress::fromValue($command->homeAddress));

        $this->statusService->changeStatus($application, Status::fromPrimitives($command->status), $command->statusNotes);
        $this->service->updateDepartments($application, $command->departmentUuids);

        $this->applicationRepository->save($application);
    }
}
