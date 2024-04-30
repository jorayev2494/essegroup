<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Project\Domains\Company\Announcement\Presentation\Http\API\REST\Controllers\AnnouncementController;

Route::group(
    ['prefix' => 'announcements', 'controller' => AnnouncementController::class],
    static function (Router $router): void {
        $router->get('/', 'index');
        $router->get('/list', 'list');
        $router->get('/view/{uuid}', 'view');
    }
);
