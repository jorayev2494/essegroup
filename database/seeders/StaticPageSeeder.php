<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Project\Domains\Admin\StaticPage\Applicaiton\StaticPage\Commands\Create\Command as CreateCommand;
use Project\Domains\Admin\StaticPage\Domain\StaticPage\StaticPageRepositoryInterface;
use Project\Domains\Admin\StaticPage\Domain\StaticPage\ValueObjects\Slug;
use Project\Infrastructure\Generators\Contracts\UuidGeneratorInterface;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;

class StaticPageSeeder extends Seeder
{
    private array $staticPages = [
        [
            'slug' => 'about-us',
            'title' => 'About page title',
            'content' => 'About page content',
        ],
        [
            'slug' => 'u-for-foreign-s',
            'title' => 'University for foreign students',
            'content' => 'University for foreign students content',
        ],
    ];

    public function __construct(
        private readonly StaticPageRepositoryInterface $staticPageRepository,
        private readonly CommandBusInterface $commandBus,
        private readonly UuidGeneratorInterface $uuidGenerator
    ) { }

    public function run(): void
    {
        $translations = [];

        foreach (config('app.available_client_translation_locales') as $locale) {
            $translations[$locale] = [
                'title' => "Static page title $locale",
                'content' => "Static page content $locale",
            ];
        }

        foreach ($this->staticPages as ['slug' => $slug, 'title' => $title, 'content' => $content]) {

            if ($this->staticPageRepository->findBySlug(Slug::fromValue($slug)) !== null) {
                continue;
            }

            $this->commandBus->dispatch(
                new CreateCommand(
                    $this->uuidGenerator->generate(),
                    $slug,
                    $translations,
                    null
                )
            );
        }
    }
}
