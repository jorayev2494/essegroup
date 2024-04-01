<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Country\Application\Country\Commands\Update;

use Project\Domains\Admin\Country\Domain\Country\Country;
use Project\Domains\Admin\Country\Domain\Country\CountryRepositoryInterface;
use Project\Domains\Admin\Country\Domain\Country\Exceptions\CountryAlreadyExistsDomainException;
use Project\Domains\Admin\Country\Domain\Country\Exceptions\CountryNotFoundDomainException;
use Project\Domains\Admin\Country\Domain\Country\ValueObjects\CompanyUuid;
use Project\Domains\Admin\Country\Domain\Country\ValueObjects\ISO;
use Project\Domains\Admin\Country\Domain\Country\ValueObjects\Uuid;
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
        $country = $this->countryRepository->findByUuid(Uuid::fromValue($command->uuid));

        $country ?? throw new CountryNotFoundDomainException();

        $country->changeValue(Value::fromValue($command->value));
        $country->changeISO(ISO::fromValue($command->iso));
        $country->changeIsActive($command->isActive);

        $this->countryRepository->save($country);
        $this->eventBus->publish(...$country->pullDomainEvents());
    }
}
