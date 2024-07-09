<?php

declare(strict_types=1);

namespace Project\Domains\Student\Authentication\Application\Authentication\Commands\Login;

use Project\Domains\Admin\Student\Domain\Student\StudentRepositoryInterface;
use Project\Domains\Admin\Student\Domain\Student\Services\DeviceService;
use Project\Domains\Admin\Student\Domain\Student\ValueObjects\Email;
use Project\Infrastructure\Services\Authentication\Contracts\AuthenticationServiceInterface;
use Project\Infrastructure\Services\Authentication\DTOs\CredentialsDTO;
use Project\Infrastructure\Services\Authentication\Enums\GuardType;

readonly class CommandHandler
{
    public function __construct(
        private StudentRepositoryInterface $repository,
        private AuthenticationServiceInterface $authenticationService,
        private DeviceService $deviceService
    ) { }

    public function __invoke(Command $command): array
    {
        $student = $this->repository->findByEmail(Email::fromValue($command->email));

        $accessToken = $this->authenticationService->authenticate(
            new CredentialsDTO($command->email, $command->password),
            GuardType::STUDENT,
            $student?->getClaims() ?? []
        );

        $device = $this->deviceService->handle($student, $command->deviceId);
        $this->repository->save($student);

        $data = $this->authenticationService->authToken($accessToken, $student, $device);

        $data['auth_data'] = array_merge(
            $data['auth_data'],
            ['company' => $student->getCompany()->isNotNull() ? $student->getCompany()->toArray() : null]
        );

        return $data;
    }
}
