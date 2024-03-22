<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Country\Application\City\Commands\Delete;

use Project\Domains\Admin\Country\Domain\City\CityRepositoryInterface;
use Project\Domains\Admin\Country\Domain\City\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private CityRepositoryInterface $cityRepository,
    )
    {

    }

    public function __invoke(Command $command): void
    {
        $city = $this->cityRepository->findByUuid(Uuid::fromValue($command->uuid));

        $this->cityRepository->delete($city);
    }
}
