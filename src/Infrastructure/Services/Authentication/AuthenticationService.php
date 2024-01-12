<?php

declare(strict_types=1);

namespace Project\Infrastructure\Services\Authentication;

use Project\Infrastructure\Services\Authentication\Enums\GuardType;
use Illuminate\Http\Response;
use Project\Infrastructure\Services\Authentication\Contracts\AuthenticatableInterface;
use Project\Infrastructure\Services\Authentication\Contracts\DeviceInterface;
use Project\Infrastructure\Services\Authentication\Contracts\AuthenticationServiceInterface;
use Project\Infrastructure\Services\Authentication\DTOs\CredentialsDTO;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Illuminate\Support\Facades\Auth;

class AuthenticationService implements AuthenticationServiceInterface
{
    public function authenticate(CredentialsDTO $data, GuardType $guard, array $claims = []): string
    {
        /** @var string $token */
        if (! ($token = Auth::guard($guard->value)->claims($claims)->attempt($data->toArray()))) {
            throw new BadRequestException('Invalid credentials!');
        }

        return $token;
    }

    public function authenticateByUuid(string $uuid, GuardType $guard, array $claims = []): string
    {
        /** @var string $token */
        if (! ($token = Auth::guard($guard->value)->claims($claims)->tokenById($uuid))) {
            throw new BadRequestException('Unauthorized', Response::HTTP_UNAUTHORIZED);
        }

        return $token;
    }

    public function invalidate(GuardType $guard): void
    {
        // Auth::guard($guard->value)->invalidate();
    }

    public function logout(GuardType $guard): void
    {
        \Project\Infrastructure\Services\Authentication\Auth::logout($guard);
    }

    public function authToken(string $accessToken, AuthenticatableInterface $authData, DeviceInterface $device): array
    {
        return [
            'access_token' => $accessToken,
            'token_type' => 'bearer',
            'refresh_token' => $device->getRefreshToken(),
            'expires_in' => auth()->factory()->getTTL() * 60,
            'auth_data' => $authData->toArray(),
        ];
    }
}
