<?php

namespace Project\Domains\Admin\YouTube\Infrastructure\YouTube\Repositories\ApiRepository;

use Project\Domains\Admin\YouTube\Domian\YouTube\YouTubeApiRepositoryInterface;

readonly class YouTubeApiRepository implements YouTubeApiRepositoryInterface
{
    private const VIDEO_IDS = [
        'Re59F7fQcYY',
        'pig4h7GS1R4',
        'b6KrzU0nkcE',
    ];

    public function __construct(
        private \Alaouy\Youtube\Youtube $youtube
    ) { }

    public function getListVideos(): array
    {
        return (array) $this->youtube->getVideoInfo(self::VIDEO_IDS, ['id', 'snippet']);
    }
}
