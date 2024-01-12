<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Application\Commands\RefreshToken;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Admin\Authentication\Domain\Device\DeviceRepositoryInterface;
use Project\Infrastructure\Generators\Contracts\TokenGeneratorInterface;
use Project\Infrastructure\Services\Authentication\Contracts\AuthenticationServiceInterface;
use Project\Infrastructure\Services\Authentication\Enums\GuardType;

readonly class CommandHandler
{
    function __construct(
        private DeviceRepositoryInterface $deviceRepository,
        private AuthenticationServiceInterface $authenticationService,
        private TokenGeneratorInterface $tokenGenerator,
    )
    {

    }

    public function __invoke(Command $command): array
    {
        $foundDevice = $this->deviceRepository->findByRefreshToken($command->refreshToken);

        if ($foundDevice === null) {
            throw new ModelNotFoundException();
        }

        $accessToken = $this->authenticationService->authenticateByUuid($foundDevice->getAuthor()->getUuid(), GuardType::ADMIN);
        $foundDevice->setRefreshToken($this->tokenGenerator->generate());

        $this->deviceRepository->save($foundDevice);

        return $this->authenticationService->authToken($accessToken, $foundDevice->getAuthor(), $foundDevice);
    }
}
