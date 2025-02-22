<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Application\Authentication\Commands\Login;

use Project\Domains\Admin\Authentication\Application\Authentication\Commands\Login\Output\Output;
use Project\Domains\Admin\Manager\Domain\Manager\ManagerRepositoryInterface;
use Project\Domains\Admin\Manager\Domain\Manager\Services\DeviceService;
use Project\Domains\Admin\Manager\Domain\Manager\ValueObjects\Email;
use Project\Domains\Admin\Manager\Domain\Role\Exceptions\RoleNotFoundDomainException;
use Project\Infrastructure\Services\Authentication\Contracts\AuthenticationServiceInterface;
use Project\Infrastructure\Services\Authentication\DTOs\CredentialsDTO;
use Project\Infrastructure\Services\Authentication\Enums\GuardType;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

readonly class CommandHandler
{
    public function __construct(
        private ManagerRepositoryInterface $repository,
        private AuthenticationServiceInterface $authenticationService,
        private DeviceService $deviceService
    ) { }

    public function __invoke(Command $command): array
    {
        $foundMember = $this->repository->findByEmail(Email::fromValue($command->email));

        if ($foundMember === null) {
            throw new BadRequestException('Invalid credentials!');
        }

        // if ($foundMember->getRole()->isNull()) {
        //     throw new RoleNotFoundDomainException();
        // }

        $accessToken = $this->authenticationService->authenticate(
            new CredentialsDTO($command->email, $command->password),
            GuardType::MANAGER,
            array_merge(
                $foundMember->getClaims() ?? [],
                [
                    'role' => $foundMember->getRole()->isNotNull() ? Output::make($foundMember->getRole())->toResponse() : [],
                ]
            )
        );

        $device = $this->deviceService->handle($foundMember, $command->deviceId);
        $this->repository->save($foundMember);

        return $this->authenticationService->authToken($accessToken, $foundMember, $device);
    }
}
