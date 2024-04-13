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
use Project\Shared\Domain\File\FileSystemInterface;
use Project\Shared\Infrastructure\File\Laravel\FileSystem;
use Project\Shared\Domain\Translation\TranslationColumnServiceInterface;
use Project\Shared\Domain\Translation\TranslationColumnService;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Transport;

class InfrastructureServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // $this->app->singleton(AuthManagerInterface::class, AuthManager::class);
        $this->app->singleton(AuthenticationServiceInterface::class, AuthenticationService::class);
        $this->app->singleton(FileSystemInterface::class, FileSystem::class);
        $this->app->singleton(UuidGeneratorInterface::class, UuidGenerator::class);
        $this->app->singleton(TokenGeneratorInterface::class, TokenGenerator::class);
        $this->app->singleton(PasswordHasherInterface::class, PasswordHasher::class);
        $this->app->singleton(TranslationColumnServiceInterface::class, TranslationColumnService::class);
        $this->app->bind(MailerInterface::class, static fn () => new Mailer(Transport::fromDsn(env('MAILER_DSN'))));
    }
}
