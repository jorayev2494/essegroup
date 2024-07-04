<?php

declare(strict_types=1);

namespace Project\Domains\Admin\YouTube\Domian\YouTube\Services\Contracts;

interface YouTubeApiServiceInterface
{
    public function getListVideos(): array;
}
