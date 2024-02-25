<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Application\Commands\Login;

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

        if ($foundMember === null) {
            throw new ModelNotFoundException();
        }

        $accessToken = $this->authenticationService->authenticate(
            new CredentialsDTO($command->email, $command->password),
            GuardType::ADMIN,
            ['company_uuid' => '885a3665-0684-43e5-be1c-677da726bbf6']
        );

        $device = $this->deviceService->handle($foundMember, $command->deviceId);
        $this->repository->save($foundMember);

        return $this->authenticationService->authToken($accessToken, $foundMember, $device);
    }
}
