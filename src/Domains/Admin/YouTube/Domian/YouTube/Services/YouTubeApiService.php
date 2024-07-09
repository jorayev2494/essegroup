<?php

declare(strict_types=1);

namespace Project\Domains\Admin\YouTube\Domian\YouTube\Services;

use Project\Domains\Admin\YouTube\Domian\YouTube\Services\Contracts\YouTubeApiServiceInterface;
use Project\Domains\Admin\YouTube\Domian\YouTube\YouTubeApiRepositoryInterface;
use Project\Infrastructure\Cache\Contracts\CacheManagerInterface;

readonly class YouTubeApiService implements YouTubeApiServiceInterface
{
    private const CACHE_KEY = 'youtube-list-videos';
    private const CACHE_HOURS = 24;

    public function __construct(
        private YouTubeApiRepositoryInterface $repository,
        private CacheManagerInterface $cacheManager
    ) { }

    public function getListVideos(): array
    {
        return $this->cacheManager->remember(self::CACHE_KEY, now()->addHours(self::CACHE_HOURS)->toDateTimeImmutable(),
            fn (): array => array_map(
                static fn (\stdClass $el): array => [
                    'video_id' => $el->id,
                    'title' => $el->snippet->title,
                    'description' => $el->snippet->description,
                    'published_at' => $el->snippet->publishedAt,
                ],
                $this->repository->getListVideos()
            )
        );
    }
}
