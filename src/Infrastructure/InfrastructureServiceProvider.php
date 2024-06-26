<?php

namespace Project\Infrastructure;

use Illuminate\Support\ServiceProvider;
use Project\Infrastructure\Archivator\Contracts\ArchivatorInterface;
use Project\Infrastructure\Archivator\ZipArchivator;
use Project\Infrastructure\Cache\CacheManager;
use Project\Infrastructure\Cache\Contracts\CacheManagerInterface;
use Project\Infrastructure\Generators\Contracts\TokenGeneratorInterface;
use Project\Infrastructure\Generators\Contracts\UuidGeneratorInterface;
use Project\Infrastructure\Generators\TokenGenerator;
use Project\Infrastructure\Generators\UuidGenerator;
use Project\Infrastructure\Hashers\Contracts\PasswordHasherInterface;
use Project\Infrastructure\Hashers\PasswordHasher;
use Project\Infrastructure\Services\Authentication\AuthenticationService;
use Project\Infrastructure\Services\Authentication\Contracts\AuthenticationServiceInterface;
use Project\Infrastructure\Services\Mailer\Contracts\MailerServiceInterface;
use Project\Infrastructure\Services\Mailer\MailerService;
use Project\Shared\Domain\File\FileSystemInterface;
use Project\Shared\Domain\Translation\TranslationColumnService;
use Project\Shared\Domain\Translation\TranslationColumnServiceInterface;
use Project\Shared\Infrastructure\File\Laravel\FileSystem;
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
        $this->app->singleton(CacheManagerInterface::class, \Illuminate\Cache\CacheManager::class);
        $this->app->singleton(MailerServiceInterface::class, MailerService::class);
        $this->app->singleton(ArchivatorInterface::class, ZipArchivator::class);
    }
}
