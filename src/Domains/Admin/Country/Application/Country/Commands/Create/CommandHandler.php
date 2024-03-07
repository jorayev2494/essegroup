<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Country\Application\Country\Commands\Create;

use Project\Domains\Admin\Country\Domain\Country\Country;
use Project\Domains\Admin\Country\Domain\Country\CountryRepositoryInterface;
use Project\Domains\Admin\Country\Domain\Country\Exceptions\CountryAlreadyExistsDomainException;
use Project\Domains\Admin\Country\Domain\Country\ValueObjects\CompanyUuid;
use Project\Domains\Admin\Country\Domain\Country\ValueObjects\ISO;
use Project\Domains\Admin\Country\Domain\Country\ValueObjects\Value;
use Project\Infrastructure\Services\Auth\AuthManager;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\Bus\Event\EventBusInterface;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private CountryRepositoryInterface $countryRepository,
        private EventBusInterface $eventBus
    ) {

    }

    public function __invoke(Command $command): void
    {
        $country = $this->countryRepository->findByValueAndByCompanyUuid(
            Value::fromValue($command->value),
            CompanyUuid::fromValue(AuthManager::getCompanyUuid())
        );

        if ($country) {
            throw new CountryAlreadyExistsDomainException();
        }

        $country = Country::create(
            $command->uuid,
            Value::fromValue($command->value),
            ISO::fromValue($command->iso),
            CompanyUuid::fromValue($command->companyUuid),
            $command->isActive
        );

        $this->countryRepository->save($country);
        $this->eventBus->publish(...$country->pullDomainEvents());
    }
}
