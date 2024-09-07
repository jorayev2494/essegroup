<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Project\Domains\Admin\Notification\Presentation\Http\API\REST\Controllers\CompanyNotificationController;

Route::group(
    ['prefix' => 'notifications', 'controller' => CompanyNotificationController::class],
    static function (Router $router): void {
        $router->get('/', 'index');
        $router->get('/quantity_unviewed', 'getQuantityUnviewed');
        $router->post('/test_default', 'testDefault');
    }
);
