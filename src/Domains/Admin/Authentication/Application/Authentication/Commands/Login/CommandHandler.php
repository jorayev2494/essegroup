<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Application\Authentication\Commands\Login;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Admin\Authentication\Domain\Member\MemberRepositoryInterface;
use Project\Domains\Admin\Authentication\Domain\Member\Services\DeviceService;
use Project\Domains\Admin\Authentication\Domain\Member\ValueObjects\Email;
use Project\Infrastructure\Services\Authentication\Contracts\AuthenticationServiceInterface;
use Project\Infrastructure\Services\Authentication\DTOs\CredentialsDTO;
use Project\Infrastructure\Services\Authentication\Enums\GuardType;

readonly class CommandHandler
{
    public function __construct(
        private MemberRepositoryInterface $repository,
        private AuthenticationServiceInterface $authenticationService,
        private DeviceService $deviceService,
    )
    {

    }

    public function __invoke(Command $command): array
    {
        $foundMember = $this->repository->findByEmail(Email::fromValue($command->email));

        $accessToken = $this->authenticationService->authenticate(
            new CredentialsDTO($command->email, $command->password),
            GuardType::ADMIN,
            $foundMember?->getClaims() ?? []
        );

        $device = $this->deviceService->handle($foundMember, $command->deviceId);
        $this->repository->save($foundMember);

        return $this->authenticationService->authToken($accessToken, $foundMember, $device);
    }
}
