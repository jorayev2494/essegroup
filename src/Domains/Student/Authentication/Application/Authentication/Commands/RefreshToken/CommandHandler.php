<?php

declare(strict_types=1);

namespace Project\Domains\Student\Authentication\Application\Authentication\Commands\RefreshToken;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Student\Authentication\Domain\Device\DeviceRepositoryInterface;
use Project\Infrastructure\Generators\Contracts\TokenGeneratorInterface;
use Project\Infrastructure\Services\Authentication\Contracts\AuthenticationServiceInterface;
use Project\Infrastructure\Services\Authentication\Enums\GuardType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

readonly class CommandHandler
{
    function __construct(
        private DeviceRepositoryInterface $deviceRepository,
        private AuthenticationServiceInterface $authenticationService,
        private TokenGeneratorInterface $tokenGenerator
    ) { }

    public function __invoke(Command $command): array
    {
        $foundDevice = $this->deviceRepository->findByRefreshToken($command->refreshToken);

        $foundDevice ?? throw new AuthenticationException('The refresh token is invalid or expired.');

        $accessToken = $this->authenticationService->authenticateByUuid(
            $foundDevice->getAuthor()->getUuid()->value,
            GuardType::STUDENT,
            $foundDevice->getAuthor()->getClaims()
        );
        $foundDevice->setRefreshToken($this->tokenGenerator->generate());

        $this->deviceRepository->save($foundDevice);

        $data = $this->authenticationService->authToken($accessToken, $foundDevice->getAuthor(), $foundDevice);

        $data['auth_data'] = array_merge(
            $data['auth_data'],
            ['company' => $foundDevice->getAuthor()->getCompany()->toArray()]
        );

        return $data;
    }
}
