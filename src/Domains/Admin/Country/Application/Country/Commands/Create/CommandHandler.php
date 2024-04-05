<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Country\Application\Country\Commands\Create;

use Project\Domains\Admin\Country\Domain\Country\Country;
use Project\Domains\Admin\Country\Domain\Country\CountryRepositoryInterface;
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
        $country = Country::create(
            Uuid::fromValue($command->uuid),
            ISO::fromValue($command->iso),
            $command->isActive
        );

        $this->translationColumnService->addTranslations($country, $command->translations);

        $this->countryRepository->save($country);
        $this->eventBus->publish(...$country->pullDomainEvents());
    }
}
