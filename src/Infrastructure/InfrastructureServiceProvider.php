<?php

namespace Project\Infrastructure;

use Illuminate\Support\ServiceProvider;
use Project\Infrastructure\Generators\Contracts\TokenGeneratorInterface;
use Project\Infrastructure\Generators\Contracts\UuidGeneratorInterface;
use Project\Infrastructure\Generators\TokenGenerator;
use Project\Infrastructure\Generators\UuidGenerator;
use Project\Infrastructure\Hashers\Contracts\PasswordHasherInterface;
use Project\Infrastructure\Hashers\PasswordHasher;
use Project\Infrastructure\Services\Authentication\AuthenticationService;
use Project\Infrastructure\Services\Authentication\Contracts\AuthenticationServiceInterface;

class InfrastructureServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(AuthenticationServiceInterface::class, AuthenticationService::class);
        $this->app->singleton(UuidGeneratorInterface::class, UuidGenerator::class);
        $this->app->singleton(TokenGeneratorInterface::class, TokenGenerator::class);
        $this->app->singleton(PasswordHasherInterface::class, PasswordHasher::class);
    }
}
