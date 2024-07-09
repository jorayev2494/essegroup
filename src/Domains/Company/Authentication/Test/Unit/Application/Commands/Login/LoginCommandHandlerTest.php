<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Test\Unit\Application\Commands\Login;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use PHPUnit\Framework\TestCase;
use Project\Domains\Admin\Authentication\Application\Authentication\Commands\Login\Command;
use Project\Domains\Admin\Authentication\Application\Authentication\Commands\Login\CommandHandler;
use Project\Domains\Admin\Authentication\Test\Unit\Fixtures\Factories\DeviceFactory;
use Project\Domains\Admin\Authentication\Test\Unit\Fixtures\Factories\MemberFactory;
use Project\Domains\Admin\Manager\Domain\Manager\ManagerRepositoryInterface;
use Project\Domains\Admin\Manager\Domain\Manager\Services\DeviceService;
use Project\Domains\Admin\Manager\Domain\Manager\ValueObjects\Email;
use Project\Infrastructure\Services\Authentication\Contracts\AuthenticationServiceInterface;
use Project\Infrastructure\Services\Authentication\DTOs\CredentialsDTO;
use Project\Infrastructure\Services\Authentication\Enums\GuardType;

class LoginCommandHandlerTest extends TestCase
{
    public function testAdminLoginSuccess(): void
    {
        $handler = new CommandHandler(
            $repository = $this->createMock(ManagerRepositoryInterface::class),
            $authenticationService = $this->createMock(AuthenticationServiceInterface::class),
            $deviceService = $this->createMock(DeviceService::class)
        );

        $repository->expects($this->once())
            ->method('findByEmail')
            ->with(Email::fromValue(MemberFactory::EMAIL))
            ->willReturn($foundMember = MemberFactory::make());

        $authenticationService->expects($this->once())
            ->method('authenticate')
            ->with(
                new CredentialsDTO(MemberFactory::EMAIL, MemberFactory::PASSWORD),
                GuardType::MANAGER
            )
            ->willReturn($accessToken = 'access_token-12345');

        $deviceService->expects($this->once())
            ->method('handle')
            ->with(
                $foundMember,
                DeviceFactory::DEVICE_ID
            )
            ->willReturn($device = DeviceFactory::make());

        $repository->expects($this->once())
            ->method('save')
            ->with($foundMember);

        $authenticationService->expects($this->once())
            ->method('authToken')
            ->with(
                $accessToken,
                $foundMember,
                $device
            )
            ->willReturn([
                "access_token" => $accessToken,
                "token_type" => "bearer",
                "refresh_token" => DeviceFactory::REFRESH_TOKEN,
                "expires_in" => 7200,
                "auth_data" => [
                    "uuid" => MemberFactory::UUID,
                    "email" => MemberFactory::EMAIL,
                ],
            ]);

        $handler(
            new Command(
                MemberFactory::EMAIL,
                MemberFactory::PASSWORD,
                DeviceFactory::DEVICE_ID,
            )
        );
    }

    public function testAdminNotFound(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $handler = new CommandHandler(
            $repository = $this->createMock(ManagerRepositoryInterface::class),
            $authenticationService = $this->createMock(AuthenticationServiceInterface::class),
            $deviceService = $this->createMock(DeviceService::class)
        );

        $repository->expects($this->once())
            ->method('findByEmail')
            ->with(Email::fromValue(MemberFactory::EMAIL))
            ->willReturn(null);

        $authenticationService->expects($this->never())
            ->method('authenticate')
            ->withAnyParameters();

        $deviceService->expects($this->never())
            ->method('handle')
            ->withAnyParameters();

        $repository->expects($this->never())
            ->method('save')
            ->withAnyParameters();

        $authenticationService->expects($this->never())
            ->method('authToken')
            ->withAnyParameters();

        $handler(
            new Command(
                MemberFactory::EMAIL,
                MemberFactory::PASSWORD,
                DeviceFactory::DEVICE_ID,
            )
        );
    }
}
