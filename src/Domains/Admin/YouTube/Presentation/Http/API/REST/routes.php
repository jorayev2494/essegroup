<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Project\Domains\Admin\YouTube\Presentation\Http\API\REST\Controllers\YouTubeController;

Route::group(
    ['prefix' => 'youtube', 'controller' => YouTubeController::class],
    static function (Router $router): void {
        $router->get('/list_videos', 'listVideos');
    }
);


