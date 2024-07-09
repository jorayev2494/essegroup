<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Country\Application\Country\Commands\Update;

use Project\Domains\Admin\Country\Domain\Country\CountryRepositoryInterface;
use Project\Domains\Admin\Country\Domain\Country\Exceptions\CountryNotFoundDomainException;
use Project\Domains\Admin\Country\Domain\Country\ValueObjects\ISO;
use Project\Domains\Admin\Country\Domain\Country\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\Bus\Event\EventBusInterface;
use Project\Shared\Domain\Translation\TranslationColumnServiceInterface;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private CountryRepositoryInterface $countryRepository,
        private TranslationColumnServiceInterface $translationColumnService,
        private EventBusInterface $eventBus
    ) {

    }

    public function __invoke(Command $command): void
    {
        $country = $this->countryRepository->findByUuid(Uuid::fromValue($command->uuid));

        $country ?? throw new CountryNotFoundDomainException();

        $this->translationColumnService->addTranslations($country, $command->translations);
        $country->changeISO(ISO::fromValue($command->iso));
        $country->changeIsActive($command->isActive);

        $this->countryRepository->save($country);
        $this->eventBus->publish(...$country->pullDomainEvents());
    }
}
