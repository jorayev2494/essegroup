<?php

declare(strict_types=1);

namespace Project\Domains\Admin\YouTube\Domian\YouTube;

interface YouTubeApiRepositoryInterface
{
    public function getListVideos(): array;
}
