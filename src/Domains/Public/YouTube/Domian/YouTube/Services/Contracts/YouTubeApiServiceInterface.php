<?php

declare(strict_types=1);

namespace Project\Domains\Public\YouTube\Domian\YouTube\Services\Contracts;

interface YouTubeApiServiceInterface
{
    public function listVideos(): array;
}
