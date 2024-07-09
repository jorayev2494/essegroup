<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Project\Domains\Admin\Announcement\Presentation\Http\API\REST\Controllers\AnnouncementController;
use Project\Domains\Admin\Announcement\Presentation\Http\API\REST\Controllers\AnnouncementStatusController;

Route::group(
    ['prefix' => 'announcements', 'controller' => AnnouncementController::class],
    static function (Router $router): void {
        $router->get('/', 'index');
        $router->get('/list', 'list');
        $router->post('/', 'store');
        $router->get('/{uuid}', 'show');
        $router->get('/view/{uuid}', 'view');
        $router->put('/{uuid}', 'update');
        $router->delete('/{uuid}', 'delete');

        Route::group(
            ['prefix' => 'statuses', 'controller' => AnnouncementStatusController::class],
            static function (Router $router): void {
                $router->get('/list', 'list');
            }
        );
    }
);
